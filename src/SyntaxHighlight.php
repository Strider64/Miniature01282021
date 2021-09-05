<?php

namespace Miniature;

class SyntaxHighlight {

static $tokens = array();// This array will be filled from the regexp-callback

public static function process($s) {
$s = htmlspecialchars($s);

// Workaround for escaped backslashes
$s = str_replace('\\\\','\\\\<e>', $s);

    $regexp = array(

    // Punctuations
    '/([\-\!\%\^\*\(\)\+\|\~\=`\{\}\[\]\:\"\'<>\?\,\.\/]+)/'
    => '<span class="P">$1</span>',

    // Numbers (also look for Hex)
    '/(?<!\w)(
    (0x|\#)[\da-f]+|
    \d+|
    \d+(px|em|cm|mm|rem|s|\%)
    )(?!\w)/ix'
    => '<span class="N">$1</span>',

    // Make the bold assumption that an
    // all uppercase word has a special meaning
    '/(?<!\w|>|\#)(
    [A-Z_0-9]{2,}
    )(?!\w)/x'
    => '<span class="D">$1</span>',

    // Keywords
    '/(?<!\w|\$|\%|\@|>)(
    and|or|xor|for|do|while|foreach|as|return|die|exit|if|then|else|
    elseif|new|delete|try|throw|catch|finally|class|function|string|
    array|object|resource|var|bool|boolean|int|integer|float|double|
    real|string|array|global|const|static|public|private|protected|
    published|extends|switch|true|false|null|void|this|self|struct|
    char|signed|unsigned|short|long
    )(?!\w|=")/ix'
    => '<span class="K">$1</span>',

    // PHP/Perl-Style Vars: $var, %var, @var
    '/(?<!\w)(
    (\$|\%|\@)(\->|\w)+
    )(?!\w)/ix'
    => '<span class="V">$1</span>'

    );

    $s = preg_replace_callback( '/(
    \/\*.*?\*\/|
    \/\/.*?\n|
    \#.[^a-fA-F0-9]+?\n|
    <!--[\s\S]+-->|
    (?<!\\\)&quot;.*?(?<!\\\)&quot;|
    (?<!\\\)\'(.*?)(?<!\\\)\'
    )/isx' , array('SyntaxHighlight', 'replaceId'),$s);

    $s = preg_replace(array_keys($regexp), array_values($regexp), $s);

    // Paste the comments and strings back in again
    // Delete the "Escaped Backslash Workaround Token" (TM)
    // and replace tabs with four spaces.
    $s = str_replace(array(array_keys(self::$tokens), '<e>', "\t"), array(array_values(self::$tokens), '', '    '), $s);

        return '<pre>'.$s.'</pre>' ;
        }

        // Regexp-Callback to replace every comment or string with a uniqid and save
        // the matched text in an array
        // This way, strings and comments will be stripped out and wont be processed
        // by the other expressions searching for keywords etc.
        static function replaceId($match) {
        $id = "##r" . uniqid('', true) . "##";

        // String or Comment?
        if(substr($match[1], 0, 2) == '//' || substr($match[1], 0, 2) == '/*' || substr($match[1], 0, 2) == '##' || substr($match[1], 0, 7) == '<!--') {
            SyntaxHighlight::$tokens[$id] = '<span class="C">' . $match[1] . '</span>';
        } else {
           SyntaxHighlight::$tokens[$id] = '<span class="S">' . $match[1] . '</span>';
        }

        return $id;
    }
}