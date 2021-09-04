<?php

use JetBrains\PhpStorm\Pure;

/*
 * PHP PDO connection
 */
$db_options = array(
    /* important! use actual prepared statements (default: emulate prepared statements) */
    PDO::ATTR_EMULATE_PREPARES => false
    /* throw exceptions on errors (default: stay silent) */
, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    /* fetch associative arrays (default: mixed arrays)    */
, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
);
$pdo = new PDO('mysql:host=' . DATABASE_HOST . ';dbname=' . DATABASE_NAME . ';charset=utf8', DATABASE_USERNAME, DATABASE_PASSWORD, $db_options);

/*
 * Grab total records (rows) in a database table
 */
function totalRecords($pdo, $table, $page = 'blog') {
    $sql = "SELECT count(id) FROM " . $table . " WHERE page=:page";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([ 'page' => $page ]);
    return $stmt->fetchColumn();

}

/*
 * Fetch Single Record by id
 */
function fetch_by_id($pdo, $table, $id) {
    $sql = "SELECT * FROM " . $table . " WHERE id=:id LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/*
 * Pagination Format
 * Read all the data from the database table in an array format
 */
function readData($pdo, $table, $page, $perPage, $offset) {
    $sql = 'SELECT * FROM ' . $table . ' WHERE page=:page ORDER BY date_updated DESC LIMIT :perPage OFFSET :blogOffset';
    $stmt = $pdo->prepare($sql); // Prepare the query:
    $stmt->execute(['perPage' => $perPage, 'blogOffset' => $offset, 'page' => $page]); // Execute the query with the supplied data:
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


/*
 * As long as you have the correct field names as the key and
 * the correct values in the corresponding keys the following
 * procedural function should work with no problem.
 *
 */

/*
 * Insert New Data doing it the procedural way
 */
function insertData(array $data, $pdo, $table) {
    try {
        /* Initialize an array */
        $attribute_pairs = [];

        /*
         * Set up the query using prepared states with the values of the array matching
         * the corresponding keys in the array
         * and the array keys being the prepared named placeholders.
         */
        $sql = 'INSERT INTO ' . $table . ' (' . implode(", ", array_keys($data)) . ')';
        $sql .= ' VALUES ( :' . implode(', :', array_keys($data)) . ')';

        /*
         * Prepare the Database Table:
         */
        $stmt = $pdo->prepare($sql);

        /*
         * Grab the corresponding values in order to
         * insert them into the table when the script
         * is executed.
         */
        foreach ($data as $key => $value)
        {
            if($key === 'id') { continue; } // Don't include the id:
            $attribute_pairs[] = $value; // Assign it to an array:
        }

        return $stmt->execute($attribute_pairs); // Execute and send boolean true:

    } catch (PDOException $e) {

        /*
         * echo "unique index" . $e->errorInfo[1] . "<br>";
         *
         * An error has occurred if the error number is for something that
         * this code is designed to handle, i.e. a duplicate index, handle it
         * by telling the user what was wrong with the data they submitted
         * failure due to a specific error number that can be recovered
         * from by the visitor submitting a different value
         *
         * return false;
         *
         * else the error is for something else, either due to a
         * programming mistake or not validating input data properly,
         * that the visitor cannot do anything about or needs to know about
         *
         * throw $e;
         *
         * re-throw the exception and let the next higher exception
         * handler, php in this case, catch and handle it
         */

        if ($e->errorInfo[1] === 1062) {
            return false;
        }

        throw $e;
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n"; // Not for a production server:
    }

    return true;
}

/*
 * Update data in the procedural way
 */
function updateData(array $data, $pdo, $table): bool
{
    /* Initialize an array */
    $attribute_pairs = [];

    /* Create the prepared statement string */
    foreach ($data as $key => $value)
    {
        if($key === 'id') { continue; } // Don't include the id:
        $attribute_pairs[] = "$key=:$key"; // Assign it to an array:
    }

    /*
     * The sql implodes the prepared statement array in the proper format
     * and updates the correct record by id.
     */
    $sql  = 'UPDATE ' . $table . ' SET ';
    $sql .= implode(", ", $attribute_pairs) . ' WHERE id =:id';

    /* Normally in two lines, but you can daisy-chain pdo method calls */
    $pdo->prepare($sql)->execute($data);

    return true;
}

/*
 * Pagination Links Done Procedurally
 */

function previous_page ($current_page): bool|int
{
    $prev = $current_page - 1;
    return ($prev > 0) ? $prev : false;
}

#[Pure] function previous_link($url="index.php", $current_page)
{
    if(previous_page($current_page) !== false) {
        $links .= '<a href="' . $url . '?page=' . previous_page($current_page) . '">';
        $links .= "&laquo; Previous</a>";
    }
    return $links;
}

function next_page($current_page, $total_pages): bool|int
{
    $next = $current_page + 1;
    return ($next <= $total_pages) ? $next : false;
}

#[Pure] function next_link($url="index.php", $current_page, $total_pages)
{
    if(next_page($current_page, $total_pages) !== false) {
        $links .= '<a href="' . $url . '?page=' . next_page($current_page, $total_pages) . '">';
        $links .= "Next &raquo;</a>";
    }
    return $links;
}

#[Pure] function links_function($url="index.php", $current_page, $total_pages): string
{
    $links .= "<div class=\"pagination\">";
    $links .=previous_link($url, $current_page); // Display previous link if there are any
    if ($current_page <= $total_pages) {
        if ($current_page == 1) {
            $links .= "<a class='selected' href=\"$url?page=1\">1</a>";
        } else {
            $links .= "<a href=\"$url?page=1\">1</a>";
        }

        $i = max(2, $current_page - 5);
        if ($i > 2) {
            $links .= '<span class="three-dots">' . " ... " . '</span>';
        }
        for (; $i < min($current_page + 6, $total_pages); $i++) {
            if ($current_page == $i) {
                $links .= "<a class='selected' href=\"$url?page=$i\">$i</a>";
            } else {
                $links .= "<a href=\"$url?page=$i\">$i</a>";
            }

        }
        if ($i !== $total_pages) {
            $links .= '<span class="three-dots">' . " ... " . '</span>';
        }
        if ($i === $total_pages) {
            $links .= "<a href=\"$url?page=$total_pages\">$total_pages</a>";
        } elseif ($i == $current_page) {
            $links .= "<a class='selected' href=\"$url?page=$total_pages\">$total_pages</a>";
        } else {
            $links .= "<a href=\"$url?page=$total_pages\">$total_pages</a>";
        }

    }
    $links .= next_link('index.php', $current_page, $total_pages); // Display next link if there are any
    $links .= "</div>";
    return $links;
}

/*
     * Delete is probably the easiest of CRUD (Create Read Update Delete),
     * but is the most dangerous method of the four as the erasure of the data is permanent of
     * PlEASE USE WITH CAUTION! (I use a small javascript code to warn users of deletion)
     */
function delete($id, $table, $pdo): bool
{
    $sql = 'DELETE FROM ' . $table . ' WHERE id=:id';
    return $pdo->prepare($sql)->execute([':id' => $id]);
}

function logout() {
    unset($_SESSION['last_login'], $_SESSION['id']);
    header("Location: index.php");
    exit();
}

