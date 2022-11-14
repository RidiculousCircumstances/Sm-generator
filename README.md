# SITEMAP GENERATOR

A simple library for fast sitemap generation in your projects.

---
## Quickstart

To start using Sitemap generator, simply install and import it:
```
composer require ridiculouscircumstances/sm-generator
```
And then:
```
use Rc/SmGeneration/Sitemap;
```

First of all, create and add your array-like data into generator, then choose the type of output file and get an array of paths to saved files:
```
use Rc/SmGeneration/Sitemap;
///

$paths = Sitemap::create()->add([
    'loc' => 'ftp://site.ru',
    'lastmod' => '2020-11-12',
    'changefreq' => 'daily',
    'priority' => '1',
],
[
    'loc' => 'http://site.ru',
    'lastmod' => '2020-11-12',
    'changefreq' => 'monthly',
    'priority' => '0.4',
])
->writeToJson('sitemap')
->writeToXml('sitemap)
->writeToCsv('sitemap')
->getPaths();


```
That's all.
>Notice: default path to saved files determines by current directory of your project. In case you want to specify your path,
> pass it into second argument of "writeTo" method.

As you may have noticed, there is support for a chain-style, each method returns instance of Sitemap class.
By default, the input data represents as an array of an associative arrays with the following keys:
- 'loc' - url address of resource,
- 'lastmod' - date of last resource modification,
- 'changefreq' - obviously, frequency of resource updating,
- 'priority' - value of page priority for search engines as they evaluate pages within a single site.

Thus, generator takes the above arguments and performs a data validation: each argument must match a specific format rule.
The rules are defined via attributes which are attached to the data transfer object, and at which point you can flexibly 
customize your own rules and your own data patterns. 
Let's take a little look at the processes under the hood.

---

### Validation

A data object looks like this:
```
class PageData 
{
    public function __construct(
        #[Url]              <--------- Validation rule attribute
        public string $loc, <--------- The corresponding property with the same name as in the input array

        #[Date]
        public string $lastmod,
        <...>
) {}
}
```

As you can see, the PageData is a plain object, and if you would like to define your own one, you can do it pretty easy, just create a 
custom class and inject its object into add-method of the Sitemap. Or rewrite an existing class:

```
class Sitemap 
{
<...>
    public function add (array $pages): Sitemap 
    {
        <...>
        foreach ($pages as $page) {
            $this->pages [] = Executor::validate(new PageData( <--------- Our pretty DTO is here!
                ...$page
            )) ?? [];
        <...>
}}
```

But what if you decide to use your own rules? Then you should look at any class, implements the ValidationRule. This is the interface:

```
interface ValidationRule
{
    public function __invoke (mixed $property, string $propertyName );
}
```

In shell nuts, the whole validation logic is as follows.
A class implementing ValidationRule is instantiated and returned by implementing ValidationAttribute class via its GetValidator method:
```
interface ValidationAttribute
{
    public function getValidator (): ValidationRule;
}
```

And then given to validate data by each DTO's property is passed to the validator's __invoke method.<br/>
The Executor class manages this process thanks for class reflection.
If the validation succeeds, Executor returns the same array as it was previously passed for validation. Otherwise, an error is returned.<br/>
Once you've written your custom validation rule and its attribute, just put it on your DTO's property:
```
#[Attribute(Attribute::TARGET_PROPERTY)]
class CustomAttribute implements ValidationAttribute
{
    public function GetValidator (): ValidationRule {
        return new CustomRule();
}}
///

class CustomRule implements ValidationRule
{
    public function __invoke(mixed $property, string $propertyName) {
        // some validation logic
}}
///

class CustomData 
{
    public function __construct(
        #[CustomAttribute]
        public string $customProperty
) {}
}
```
---
### Output Writing

After the validation was successful, the methods for writing to the file are called inside the Sitemap.
There are three types of possible writing at this moment: to json, csv and to xml.<br/>
Each method delegates write-command to the special writer class. And each writer extends abstract Writer class, which 
contains common writing logic as follows:
```
abstract class Writer 
{
<...>
protected static function write (array $content, string $name, ?string $path): string|null
    {   <...>
        self::checkContent($content);
        $path = self::setPath($name, $path);
        $output = static::build($content);
        return self::save($path, $output);
        <...>
    }
<...>
```
Common logic consists in:<br/>
- checking for non-empty input data,
- path creating (if path already exists, it will be returned, or created new one. If the path is not passed, the default path is used),
- saving into the file.

The child classes (e.g. XmlWriter, JsonWriter etc.) know only how to build its own data formats, and it is implemented in its "build" methods, 
which called by abstract Writer class via static pointer. The child classes know nothing else.<br/>
This design approach makes it easy to change writers or add new ones just by writing its special data-format build logic in child classes.<br/>
E.g.:
```
class CustomWriter extends Writer
{
    protected static string $ext = 'custom type';

    protected static function build (array $content): string
    {
        //custom logic
    }
}

```
And then all you need to do is add a custom writer into Sitemap custom "writeTo" method:
```
class Sitemap 
{
    <...>
    public function writeToCustomType (...args) {
        $this->paths [] = CustomWriter::write(...args);
        return $this;
}
    <...>

}
```

Thus, the library not only allows you to quickly and easily generate a site map, but it is also flexible for modifications.

---
### Thanks for your attention!