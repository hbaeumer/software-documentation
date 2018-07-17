# hbaeumer code rules Coding Standard
## Empty Statements
Control Structures must have at least one statement inside of the body.
  <table>
   <tr>
    <th>Valid: There is a statement inside the control structure.</th>
    <th>Invalid: The control structure has no statements.</th>
   </tr>
   <tr>
<td>

    if ($test) {
        $var = 1;
    }

</td>
<td>

    if ($test) {
        // do nothing
    }

</td>
   </tr>
  </table>
## Condition-Only For Loops
For loops that have only a second expression (the condition) should be converted to while loops.
  <table>
   <tr>
    <th>Valid: A for loop is used with all three expressions.</th>
    <th>Invalid: A for loop is used without a first or third expression.</th>
   </tr>
   <tr>
<td>

    for ($i = 0; $i < 10; $i++) {
        echo "{$i}\n";
    }

</td>
<td>

    for (;$test;) {
        $test = doSomething();
    }

</td>
   </tr>
  </table>
## For Loops With Function Calls in the Test
For loops should not call functions inside the test for the loop when they can be computed beforehand.
  <table>
   <tr>
    <th>Valid: A for loop that determines its end condition before the loop starts.</th>
    <th>Invalid: A for loop that unnecessarily computes the same value on every iteration.</th>
   </tr>
   <tr>
<td>

    $end = count($foo);
    for ($i = 0; $i < $end; $i++) {
        echo $foo[$i]."\n";
    }

</td>
<td>

    for ($i = 0; $i < count($foo); $i++) {
        echo $foo[$i]."\n";
    }

</td>
   </tr>
  </table>
## Jumbled Incrementers
Incrementers in nested loops should use different variable names.
  <table>
   <tr>
    <th>Valid: Two different variables being used to increment.</th>
    <th>Invalid: Inner incrementer is the same variable name as the outer one.</th>
   </tr>
   <tr>
<td>

    for ($i = 0; $i < 10; $i++) {
        for ($j = 0; $j < 10; $j++) {
        }
    }

</td>
<td>

    for ($i = 0; $i < 10; $i++) {
        for ($j = 0; $j < 10; $i++) {
        }
    }

</td>
   </tr>
  </table>
## Unconditional If Statements
If statements that are always evaluated should not be used.
  <table>
   <tr>
    <th>Valid: An if statement that only executes conditionally.</th>
    <th>Invalid: An if statement that is always performed.</th>
   </tr>
   <tr>
<td>

    if ($test) {
        $var = 1;
    }

</td>
<td>

    if (true) {
        $var = 1;
    }

</td>
   </tr>
  </table>
  <table>
   <tr>
    <th>Valid: An if statement that only executes conditionally.</th>
    <th>Invalid: An if statement that is never performed.</th>
   </tr>
   <tr>
<td>

    if ($test) {
        $var = 1;
    }

</td>
<td>

    if (false) {
        $var = 1;
    }

</td>
   </tr>
  </table>
## Unnecessary Final Modifiers
Methods should not be declared final inside of classes that are declared final.
  <table>
   <tr>
    <th>Valid: A method in a final class is not marked final.</th>
    <th>Invalid: A method in a final class is also marked final.</th>
   </tr>
   <tr>
<td>

    final class Foo
    {
        public function bar()
        {
        }
    }

</td>
<td>

    final class Foo
    {
        public final function bar()
        {
        }
    }

</td>
   </tr>
  </table>
## Unused function parameters
All parameters in a functions signature should be used within the function.
  <table>
   <tr>
    <th>Valid: All the parameters are used.</th>
    <th>Invalid: One of the parameters is not being used.</th>
   </tr>
   <tr>
<td>

    function addThree($a, $b, $c)
    {
        return $a + $b + $c;
    }

</td>
<td>

    function addThree($a, $b, $c)
    {
        return $a + $b;
    }

</td>
   </tr>
  </table>
## Useless Overriding Methods
Methods should not be defined that only call the parent method.
  <table>
   <tr>
    <th>Valid: A method that extends functionality on a parent method.</th>
    <th>Invalid: An overriding method that only calls the parent.</th>
   </tr>
   <tr>
<td>

    final class Foo
    {
        public function bar()
        {
            parent::bar();
            $this->doSomethingElse();
        }
    }

</td>
<td>

    final class Foo
    {
        public function bar()
        {
            parent::bar();
        }
    }

</td>
   </tr>
  </table>
## Aligning Blocks of Assignments
There should be one space on either side of an equals sign used to assign a value to a variable. In the case of a block of related assignments, more space may be inserted to promote readability.
  <table>
   <tr>
    <th>Equals signs aligned</th>
    <th>Not aligned; harder to read</th>
   </tr>
   <tr>
<td>

    $shortVar        = (1 + 2);
    $veryLongVarName = 'string';
    $var             = foo($bar, $baz, $quux);

</td>
<td>

    $shortVar = (1 + 2);
    $veryLongVarName = 'string';
    $var = foo($bar, $baz, $quux);

</td>
   </tr>
  </table>
When using plus-equals, minus-equals etc. still ensure the equals signs are aligned to one space after the longest variable name.
  <table>
   <tr>
    <th>Equals signs aligned; only one space after longest var name</th>
    <th>Two spaces after longest var name</th>
   </tr>
   <tr>
<td>

    $shortVar       += 1;
    $veryLongVarName = 1;

</td>
<td>

    $shortVar        += 1;
    $veryLongVarName  = 1;

</td>
   </tr>
  </table>
  <table>
   <tr>
    <th>Equals signs aligned</th>
    <th>Equals signs not aligned</th>
   </tr>
   <tr>
<td>

    $shortVar         = 1;
    $veryLongVarName -= 1;

</td>
<td>

    $shortVar        = 1;
    $veryLongVarName -= 1;

</td>
   </tr>
  </table>
## Short Array Syntax
Short array syntax must be used to define arrays.
  <table>
   <tr>
    <th>Valid: Short form of array.</th>
    <th>Invalid: Long form of array.</th>
   </tr>
   <tr>
<td>

    $arr = [
        'foo' => 'bar',
    ];

</td>
<td>

    $arr = array(
        'foo' => 'bar',
    );

</td>
   </tr>
  </table>
## Function Comments
Functions must have a non-empty doc comment.  The short description must be on the second line of the comment.  Each description must have one blank comment line before and after.  There must be one blank line before the tags in the comments.  There must be a tag for each of the parameters in the right order with the right variable names with a comment.  There must be a return tag.  Any throw tag must have an exception class.
  <table>
   <tr>
    <th>Valid: A function doc comment is used.</th>
    <th>Invalid: No doc comment for the function.</th>
   </tr>
   <tr>
<td>

    /**
     * Short description here.
     *
     * @return void
     */
     function foo()
     {
     }

</td>
<td>

    function foo()
     {
     }

</td>
   </tr>
  </table>
  <table>
   <tr>
    <th>Valid: Short description is the second line of the comment.</th>
    <th>Invalid: An extra blank line before the short description.</th>
   </tr>
   <tr>
<td>

    /**
     * Short description here.
     *
     * @return void
     */
     function foo()
     {
     }

</td>
<td>

    /**
     * 
     * Short description here.
     *
     * @return void
     */
     function foo()
     {
     }

</td>
   </tr>
  </table>
  <table>
   <tr>
    <th>Valid: Exactly one blank line around descriptions.</th>
    <th>Invalid: Extra blank lines around the descriptions.</th>
   </tr>
   <tr>
<td>

    /**
     * Short description here.
     * 
     * Long description here.
     * 
     * @return void
     */
     function foo()
     {
     }

</td>
<td>

    /**
     * Short description here.
     * 
     * 
     * Long description here.
     * 
     * 
     * @return void
     */
     function foo()
     {
     }

</td>
   </tr>
  </table>
  <table>
   <tr>
    <th>Valid: Exactly one blank line before the tags.</th>
    <th>Invalid: Extra blank lines before the tags.</th>
   </tr>
   <tr>
<td>

    /**
     * Short description here.
     *
     * Long description here.
     * 
     * @return void
     */
     function foo()
     {
     }

</td>
<td>

    /**
     * Short description here.
     *
     * Long description here.
     * 
     * 
     * @return void
     */
     function foo()
     {
     }

</td>
   </tr>
  </table>
  <table>
   <tr>
    <th>Valid: Throws tag has an exception class.</th>
    <th>Invalid: No exception class given for throws tag.</th>
   </tr>
   <tr>
<td>

    /**
     * Short description here.
     *
     * @return void
     * @throws FooException
     */
     function foo()
     {
     }

</td>
<td>

    /**
     * Short description here.
     *
     * @return void
     * @throws
     */
     function foo()
     {
     }

</td>
   </tr>
  </table>
  <table>
   <tr>
    <th>Valid: Return tag present.</th>
    <th>Invalid: No return tag.</th>
   </tr>
   <tr>
<td>

    /**
     * Short description here.
     *
     * @return void
     */
     function foo()
     {
     }

</td>
<td>

    /**
     * Short description here.
     */
     function foo()
     {
     }

</td>
   </tr>
  </table>
  <table>
   <tr>
    <th>Valid: Param names are correct.</th>
    <th>Invalid: Wrong parameter name doesn't match function signature.</th>
   </tr>
   <tr>
<td>

    /**
     * Short description here.
     *
     * @param string $foo Foo parameter
     * @param string $bar Bar parameter
     * @return void
     */
     function foo($foo, $bar)
     {
     }

</td>
<td>

    /**
     * Short description here.
     *
     * @param string $foo Foo parameter
     * @param string $qux Bar parameter
     * @return void
     */
     function foo($foo, $bar)
     {
     }

</td>
   </tr>
  </table>
  <table>
   <tr>
    <th>Valid: Param names are ordered correctly.</th>
    <th>Invalid: Wrong parameter order.</th>
   </tr>
   <tr>
<td>

    /**
     * Short description here.
     *
     * @param string $foo Foo parameter
     * @param string $bar Bar parameter
     * @return void
     */
     function foo($foo, $bar)
     {
     }

</td>
<td>

    /**
     * Short description here.
     *
     * @param string $bar Bar parameter
     * @param string $foo Foo parameter
     * @return void
     */
     function foo($foo, $bar)
     {
     }

</td>
   </tr>
  </table>
## Including Code
Anywhere you are unconditionally including a class file, use *require_once*. Anywhere you are conditionally including a class file (for example, factory methods), use *include_once*. Either of these will ensure that class files are included only once. They share the same file list, so you don't need to worry about mixing them - a file included with *require_once* will not be included again by *include_once*.
Note that *include_once* and *require_once* are statements, not functions. Parentheses should not surround the subject filename.
  <table>
   <tr>
    <th>Valid: used as statement</th>
    <th>Invalid: used as function</th>
   </tr>
   <tr>
<td>

    require_once 'PHP/CodeSniffer.php';

</td>
<td>

    require_once('PHP/CodeSniffer.php');

</td>
   </tr>
  </table>
## Default Values in Function Declarations
Arguments with default values go at the end of the argument list.
  <table>
   <tr>
    <th>Valid: argument with default value at end of declaration</th>
    <th>Invalid: argument with default value at start of declaration</th>
   </tr>
   <tr>
<td>

    function connect($dsn, $persistent = false)
    {
        ...
    }

</td>
<td>

    function connect($persistent = false, $dsn)
    {
        ...
    }

</td>
   </tr>
  </table>
## Class Declarations
There should be exactly 1 space between the abstract or final keyword and the class keyword and between the class keyword and the class name.  The extends and implements keywords, if present, must be on the same line as the class name.  When interfaces implemented are spread over multiple lines, there should be exactly 1 interface mentioned per line indented by 1 level.  The closing brace of the class must go on the first line after the body of the class and must be on a line by itself.
  <table>
   <tr>
    <th>Valid: Correct spacing around class keyword.</th>
    <th>Invalid: 2 spaces used around class keyword.</th>
   </tr>
   <tr>
<td>

    abstract class Foo
    {
    }

</td>
<td>

    abstract  class  Foo
    {
    }

</td>
   </tr>
  </table>
## Property Declarations
Property names should not be prefixed with an underscore to indicate visibility.  Visibility should be used to declare properties rather than the var keyword.  Only one property should be declared within a statement.
  <table>
   <tr>
    <th>Valid: Correct property naming.</th>
    <th>Invalid: An underscore prefix used to indicate visibility.</th>
   </tr>
   <tr>
<td>

    class Foo
    {
        private $bar;
    }

</td>
<td>

    class Foo
    {
        private $_bar;
    }

</td>
   </tr>
  </table>
  <table>
   <tr>
    <th>Valid: Visibility of property declared.</th>
    <th>Invalid: Var keyword used to declare property.</th>
   </tr>
   <tr>
<td>

    class Foo
    {
        private $bar;
    }

</td>
<td>

    class Foo
    {
        var $bar;
    }

</td>
   </tr>
  </table>
  <table>
   <tr>
    <th>Valid: One property declared per statement.</th>
    <th>Invalid: Multiple properties declared in one statement.</th>
   </tr>
   <tr>
<td>

    class Foo
    {
        private $bar;
        private $baz;
    }

</td>
<td>

    class Foo
    {
        private $bar, $baz;
    }

</td>
   </tr>
  </table>
## Control Structure Spacing
Control Structures should have 0 spaces after opening parentheses and 0 spaces before closing parentheses.
  <table>
   <tr>
    <th>Valid: Correct spacing.</th>
    <th>Invalid: Whitespace used inside the parentheses.</th>
   </tr>
   <tr>
<td>

    if ($foo) {
        $var = 1;
    }

</td>
<td>

    if ( $foo ) {
        $var = 1;
    }

</td>
   </tr>
  </table>
## Elseif Declarations
PHP's elseif keyword should be used instead of else if.
  <table>
   <tr>
    <th>Valid: Single word elseif keyword used.</th>
    <th>Invalid: Separate else and if keywords used.</th>
   </tr>
   <tr>
<td>

    if ($foo) {
        $var = 1;
    } elseif ($bar) {
        $var = 2;
    }

</td>
<td>

    if ($foo) {
        $var = 1;
    } else if ($bar) {
        $var = 2;
    }

</td>
   </tr>
  </table>
## Switch Declarations
Case statements should be indented 4 spaces from the switch keyword.  It should also be followed by a space.  Colons in switch declarations should not be preceded by whitespace.  Break statements should be indented 4 more spaces from the case statement.  There must be a comment when falling through from one case into the next.
  <table>
   <tr>
    <th>Valid: Case statement indented correctly.</th>
    <th>Invalid: Case statement not indented 4 spaces.</th>
   </tr>
   <tr>
<td>

    switch ($foo) {
        case 'bar':
            break;
    }

</td>
<td>

    switch ($foo) {
    case 'bar':
        break;
    }

</td>
   </tr>
  </table>
  <table>
   <tr>
    <th>Valid: Case statement followed by 1 space.</th>
    <th>Invalid: Case statement not followed by 1 space.</th>
   </tr>
   <tr>
<td>

    switch ($foo) {
        case 'bar':
            break;
    }

</td>
<td>

    switch ($foo) {
        case'bar':
            break;
    }

</td>
   </tr>
  </table>
  <table>
   <tr>
    <th>Valid: Colons not prefixed by whitespace.</th>
    <th>Invalid: Colons prefixed by whitespace.</th>
   </tr>
   <tr>
<td>

    switch ($foo) {
        case 'bar':
            break;
        default:
            break;
    }

</td>
<td>

    switch ($foo) {
        case 'bar' :
            break;
        default :
            break;
    }

</td>
   </tr>
  </table>
  <table>
   <tr>
    <th>Valid: Break statement indented correctly.</th>
    <th>Invalid: Break statement not indented 4 spaces.</th>
   </tr>
   <tr>
<td>

    switch ($foo) {
        case 'bar':
            break;
    }

</td>
<td>

    switch ($foo) {
        case 'bar':
        break;
    }

</td>
   </tr>
  </table>
  <table>
   <tr>
    <th>Valid: Comment marking intentional fall-through.</th>
    <th>Invalid: No comment marking intentional fall-through.</th>
   </tr>
   <tr>
<td>

    switch ($foo) {
        case 'bar':
        // no break
        default:
            break;
    }

</td>
<td>

    switch ($foo) {
        case 'bar':
        default:
            break;
    }

</td>
   </tr>
  </table>
## End File Newline
PHP Files should end with exactly one newline.
## Method Declarations
Method names should not be prefixed with an underscore to indicate visibility.  The static keyword, when present, should come after the visibility declaration, and the final and abstract keywords should come before.
  <table>
   <tr>
    <th>Valid: Correct method naming.</th>
    <th>Invalid: An underscore prefix used to indicate visibility.</th>
   </tr>
   <tr>
<td>

    class Foo
    {
        private function bar()
        {
        }
    }

</td>
<td>

    class Foo
    {
        private function _bar()
        {
        }
    }

</td>
   </tr>
  </table>
  <table>
   <tr>
    <th>Valid: Correct ordering of method prefixes.</th>
    <th>Invalid: static keyword used before visibility and final used after.</th>
   </tr>
   <tr>
<td>

    class Foo
    {
        final public static function bar()
        {
        }
    }

</td>
<td>

    class Foo
    {
        static public final function bar()
        {
        }
    }

</td>
   </tr>
  </table>
## Namespace Declarations
There must be one blank line after the namespace declaration.
  <table>
   <tr>
    <th>Valid: One blank line after the namespace declaration.</th>
    <th>Invalid: No blank line after the namespace declaration.</th>
   </tr>
   <tr>
<td>

    namespace \Foo\Bar;
    
    use \Baz;

</td>
<td>

    namespace \Foo\Bar;
    use \Baz;

</td>
   </tr>
  </table>
## Namespace Declarations
Each use declaration must contain only one namespace and must come after the first namespace declaration.  There should be one blank line after the final use statement.
  <table>
   <tr>
    <th>Valid: One use declaration per namespace.</th>
    <th>Invalid: Multiple namespaces in a use declaration.</th>
   </tr>
   <tr>
<td>

    use \Foo;
    use \Bar;

</td>
<td>

    use \Foo, \Bar;

</td>
   </tr>
  </table>
  <table>
   <tr>
    <th>Valid: Use statements come after first namespace.</th>
    <th>Invalid: Namespace declared after use.</th>
   </tr>
   <tr>
<td>

    namespace \Foo;
    
    use \Bar;

</td>
<td>

    use \Bar;
    
    namespace \Foo;

</td>
   </tr>
  </table>
  <table>
   <tr>
    <th>Valid: A single blank line after the final use statement.</th>
    <th>Invalid: No blank line after the final use statement.</th>
   </tr>
   <tr>
<td>

    use \Foo;
    use \Bar;
    
    class Baz
    {
    }

</td>
<td>

    use \Foo;
    use \Bar;
    class Baz
    {
    }

</td>
   </tr>
  </table>
## Class Declaration
Each class must be in a file by itself and must be under a namespace (a top-level vendor name).
  <table>
   <tr>
    <th>Valid: One class in a file.</th>
    <th>Invalid: Multiple classes in a single file.</th>
   </tr>
   <tr>
<td>

    <?php
    namespace Foo; class Bar { }

</td>
<td>

    <?php namespace Foo; class Bar { } class Baz { }

</td>
   </tr>
  </table>
  <table>
   <tr>
    <th>Valid: A vendor-level namespace is used.</th>
    <th>Invalid: No namespace used in file.</th>
   </tr>
   <tr>
<td>

    <?php namespace Foo; class Bar { }

</td>
<td>

    <?php class Bar { }

</td>
   </tr>
  </table>
## Side Effects
A php file should either contain declarations with no side effects, or should just have logic (including side effects) with no declarations.
  <table>
   <tr>
    <th>Valid: A class defined in a file by itself.</th>
    <th>Invalid: A class defined in a file with other code.</th>
   </tr>
   <tr>
<td>

    <?php
    class Foo { }

</td>
<td>

    <?php class Foo { } echo "Class Foo loaded."

</td>
   </tr>
  </table>
## PHP Code Tags
Always use &lt;?php ?&gt; to delimit PHP code, not the &lt;? ?&gt; shorthand. This is the most portable way to include PHP code on differing operating systems and setups.
## Byte Order Marks
Byte Order Marks that may corrupt your application should not be used.  These include 0xefbbbf (UTF-8), 0xfeff (UTF-16 BE) and 0xfffe (UTF-16 LE).
## Constant Names
Constants should always be all-uppercase, with underscores to separate words.
  <table>
   <tr>
    <th>Valid: all uppercase</th>
    <th>Invalid: mixed case</th>
   </tr>
   <tr>
<td>

    define('FOO_CONSTANT', 'foo');
    
    class FooClass
    {
        const FOO_CONSTANT = 'foo';
    }

</td>
<td>

    define('Foo_Constant', 'foo');
    
    class FooClass
    {
        const foo_constant = 'foo';
    }

</td>
   </tr>
  </table>
## Line Endings
Unix-style line endings are preferred (&quot;\n&quot; instead of &quot;\r\n&quot;).
## Line Length
It is recommended to keep lines at approximately 80 characters long for better code readability.
## Multiple Statements On a Single Line
Multiple statements are not allowed on a single line.
  <table>
   <tr>
    <th>Valid: Two statements are spread out on two separate lines.</th>
    <th>Invalid: Two statements are combined onto one line.</th>
   </tr>
   <tr>
<td>

    $foo = 1;
    $bar = 2;

</td>
<td>

    $foo = 1; $bar = 2;

</td>
   </tr>
  </table>
## Scope Indentation
Indentation for control structures, classes, and functions should be 4 spaces per level.
  <table>
   <tr>
    <th>Valid: 4 spaces are used to indent a control structure.</th>
    <th>Invalid: 8 spaces are used to indent a control structure.</th>
   </tr>
   <tr>
<td>

    if ($test) {
        $var = 1;
    }

</td>
<td>

    if ($test) {
            $var = 1;
    }

</td>
   </tr>
  </table>
## No Tab Indentation
Spaces should be used for indentation instead of tabs.
## Lowercase Keywords
All PHP keywords should be lowercase.
  <table>
   <tr>
    <th>Valid: Lowercase array keyword used.</th>
    <th>Invalid: Non-lowercase array keyword used.</th>
   </tr>
   <tr>
<td>

    $foo = array();

</td>
<td>

    $foo = Array();

</td>
   </tr>
  </table>
## Lowercase PHP Constants
The *true*, *false* and *null* constants must always be lowercase.
  <table>
   <tr>
    <th>Valid: lowercase constants</th>
    <th>Invalid: uppercase constants</th>
   </tr>
   <tr>
<td>

    if ($var === false || $var === null) {
        $var = true;
    }

</td>
<td>

    if ($var === FALSE || $var === NULL) {
        $var = TRUE;
    }

</td>
   </tr>
  </table>
## Scope Keyword Spacing
The php keywords static, public, private, and protected should have one space after them.
  <table>
   <tr>
    <th>Valid: A single space following the keywords.</th>
    <th>Invalid: Multiple spaces following the keywords.</th>
   </tr>
   <tr>
<td>

    public static function foo()
    {
    }

</td>
<td>

    public  static  function foo()
    {
    }

</td>
   </tr>
  </table>
## Lowercase Function Keywords
The php keywords function, public, private, protected, and static should be lowercase.
  <table>
   <tr>
    <th>Valid: Lowercase function keyword.</th>
    <th>Invalid: Uppercase function keyword.</th>
   </tr>
   <tr>
<td>

    function foo()
    {
        return true;
    }

</td>
<td>

    FUNCTION foo()
    {
        return true;
    }

</td>
   </tr>
  </table>
## Function Argument Spacing
Function arguments should have one space after a comma, and single spaces surrounding the equals sign for default values.
  <table>
   <tr>
    <th>Valid: Single spaces after a comma.</th>
    <th>Invalid: No spaces after a comma.</th>
   </tr>
   <tr>
<td>

    function foo($bar, $baz)
    {
    }

</td>
<td>

    function foo($bar,$baz)
    {
    }

</td>
   </tr>
  </table>
  <table>
   <tr>
    <th>Valid: Single spaces around an equals sign in function declaration.</th>
    <th>Invalid: No spaces around an equals sign in function declaration.</th>
   </tr>
   <tr>
<td>

    function foo($bar, $baz = true)
    {
    }

</td>
<td>

    function foo($bar, $baz=true)
    {
    }

</td>
   </tr>
  </table>
## Foreach Loop Declarations
There should be a space between each element of a foreach loop and the as keyword should be lowercase.
  <table>
   <tr>
    <th>Valid: Correct spacing used.</th>
    <th>Invalid: Invalid spacing used.</th>
   </tr>
   <tr>
<td>

    foreach ($foo as $bar => $baz) {
        echo $baz;
    }

</td>
<td>

    foreach ( $foo  as  $bar=>$baz ) {
        echo $baz;
    }

</td>
   </tr>
  </table>
  <table>
   <tr>
    <th>Valid: Lowercase as keyword.</th>
    <th>Invalid: Uppercase as keyword.</th>
   </tr>
   <tr>
<td>

    foreach ($foo as $bar => $baz) {
        echo $baz;
    }

</td>
<td>

    foreach ($foo AS $bar => $baz) {
        echo $baz;
    }

</td>
   </tr>
  </table>
## For Loop Declarations
In a for loop declaration, there should be no space inside the brackets and there should be 0 spaces before and 1 space after semicolons.
  <table>
   <tr>
    <th>Valid: Correct spacing used.</th>
    <th>Invalid: Invalid spacing used inside brackets.</th>
   </tr>
   <tr>
<td>

    for ($i = 0; $i < 10; $i++) {
        echo $i;
    }

</td>
<td>

    for ( $i = 0; $i < 10; $i++ ) {
        echo $i;
    }

</td>
   </tr>
  </table>
  <table>
   <tr>
    <th>Valid: Correct spacing used.</th>
    <th>Invalid: Invalid spacing used before semicolons.</th>
   </tr>
   <tr>
<td>

    for ($i = 0; $i < 10; $i++) {
        echo $i;
    }

</td>
<td>

    for ($i = 0 ; $i < 10 ; $i++) {
        echo $i;
    }

</td>
   </tr>
  </table>
  <table>
   <tr>
    <th>Valid: Correct spacing used.</th>
    <th>Invalid: Invalid spacing used after semicolons.</th>
   </tr>
   <tr>
<td>

    for ($i = 0; $i < 10; $i++) {
        echo $i;
    }

</td>
<td>

    for ($i = 0;$i < 10;$i++) {
        echo $i;
    }

</td>
   </tr>
  </table>
## Lowercase Control Structure Keywords
The php keywords if, else, elseif, foreach, for, do, switch, while, try, and catch should be lowercase.
  <table>
   <tr>
    <th>Valid: Lowercase if keyword.</th>
    <th>Invalid: Uppercase if keyword.</th>
   </tr>
   <tr>
<td>

    if ($foo) {
        $bar = true;
    }

</td>
<td>

    IF ($foo) {
        $bar = true;
    }

</td>
   </tr>
  </table>
## Inline Control Structures
Control Structures should use braces.
  <table>
   <tr>
    <th>Valid: Braces are used around the control structure.</th>
    <th>Invalid: No braces are used for the control structure..</th>
   </tr>
   <tr>
<td>

    if ($test) {
        $var = 1;
    }

</td>
<td>

    if ($test)
        $var = 1;

</td>
   </tr>
  </table>
Documentation generated on Thu, 05 Jul 2018 00:12:02 +0200 by [PHP_CodeSniffer 3.3.0](https://github.com/squizlabs/PHP_CodeSniffer)
