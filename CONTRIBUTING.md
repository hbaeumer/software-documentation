/* CONTRIBUTE */

This is the contributing.md of our project. Great to have you here. Here are a few ways you can help make this project better!

# Contribute.md

##Coding Standards

This Software follows the standards defined in the [PSR-1](https://www.php-fig.org/psr/psr-1/), [PSR-2](https://www.php-fig.org/psr/psr-2/) and [PSR-4](https://www.php-fig.org/psr/psr-4/) documents.

### Structure

* Add a single space after each comma delimiter;
* Add a single space around binary operators (==, &&, ...), with the exception of the concatenation (.) operator;
* Place unary operators (!, --, ...) adjacent to the affected variable;
* Always use identical comparison unless you need type juggling;
* Use Yoda conditions when checking a variable against an expression to avoid an accidental assignment inside the condition statement (this applies to ==, !=, ===, and !==);
* Add a comma after each array item in a multi-line array, even after the last one;
* Add a blank line before return statements, unless the return is alone inside a statement-group (like an if statement);
* Use return null; when a function explicitly returns null values and use return; when the function returns void values;
* Use braces to indicate control structure body regardless of the number of statements it contains;
* Define one class per file - this does not apply to private helper classes that are not intended to be instantiated from the outside and thus are not concerned by the PSR-0 and PSR-4 autoload standards;
* Declare the class inheritance and all the implemented interfaces on the same line as the class name;
* Declare class properties before methods;
* Declare public methods first, then protected ones and finally private ones. The exceptions to this rule are the class constructor and the setUp() and tearDown() methods of PHPUnit tests, which must always be the first methods to increase readability;
* Declare all the arguments on the same line as the method/function name, no matter how many arguments there are;
* Use parentheses when instantiating classes regardless of the number of arguments the constructor has;
* Exception and error message strings must be concatenated using sprintf;
* Calls to trigger_error with type E_USER_DEPRECATED must be switched to opt-in via @ operator. Read more at Deprecations;
* Do not use else, elseif, break after if and case conditions which return or throw something;
* Do not use spaces around [ offset accessor and before ] offset accessor.

### Naming Conventions

* Use camelCase, not underscores, for variable, function and method names, arguments;
* Use underscores for option names and parameter names;
* Use namespaces for all classes;
* Prefix abstract classes with Abstract;
* Suffix interfaces with Interface;
* Suffix traits with Trait;
* Suffix exceptions with Exception;
* Use alphanumeric characters and underscores for file names [a-zA-Z0-9_];
* For type-hinting in PHPDocs and casting, use bool (instead of boolean or Boolean), int (instead of integer), float (instead of double or real);
* Don't forget to look at the more verbose Conventions document for more subjective naming considerations.

### Documentation

* Add PHPDoc blocks for all classes, methods, and functions;
* Group annotations together so that annotations of the same type immediately follow each other, and annotations of a different type are separated by a single blank line;
* Omit the @return tag if the method does not return anything;
* The @package and @subpackage annotations are not used.

### Directory Structure

Inspired by [Symfony](http://symfony.com/doc/current/quick_tour/the_architecture.html)
, [Zend](https://framework.zend.com/manual/1.12/en/project-structure.project.html)
and [Codeception](http://codeception.com/docs/01-Introduction)
this is the directory structure for the application.

```
.
├── bin             # Executable files (e.g. bin/console).
├── build           # buildscript files i.e. code coverage reports
├── config          # configuration
├── docs            # docs
│   └── generated   # generated doc files
│                    # This information would not be committed to the git repository.
│                    
├── etc             # docker configs (if neccessary)
├── src             # the project's PHP code
├── tests           # Automatic tests (e.g. Unit tests).
│   ├── Acceptance  #   with codecesption we can seperate the test.  
│   ├── Functional  
│   └── Unit        
│
├── var             # Generated files (cache, logs, etc.). The application needs write access
│   ├── cache       #   This directory provides a place to store application data
│   ├── logs        #   that is volatile and possibly temporary.
│   │               #   The disturbance of data in this directory might cause the application to fail.
│   │               #   Also, the information in this directory may or may not be committed to a repository.
│   │                
│   └── temp        # temp files
│                   #   The temp/ folder is set aside for transient application data.
│                   #   This information would not be committed to the git repository.
│                   #   If data under the temp/ directory were deleted,
│                   #   the application should be able to continue running with a 
│                   #   possible decrease in performance until data is once again restored or recached.
│
├── vendor          # The third-party dependencies.
└── web             # The web root directory.
```
