# Smarty Plugins

This is a repo of various smarty plugins. Hopefully someone else finds them useful.

## attr

This `attr` function is meant to shorten the syntax used to set various html attributes 
more specifically the `class` attribute. It was inspired by the `bindAttr` helper in [ember.js](http://emberjs.com/).
You provide a `target` object and that is used to 
grab properties from. If the value passed in for the attribute is a property on the `target` 
the value of that property is returned. If it is not a valid property then the string literal will 
be used instead. 

When dealing with a `class` attribute it acts a little differently. First of all you can pass in a 
space delimited list of property names or values. If the property is a boolean it will dashize the 
property name `some_bool => is-some_bool`. If you don't want that you can pass in an alternate value 
for when the bool is true `some_bool:this-was-true => this-was-true`. If the bool is false the class 
won't be added to the attribute.

    # Sample object
    $obj->active     = true;
    $obj->title      = 'Whaddup';
    $obj->status     = 'pending';
    $obj->public_url = 'http://example.com';
    
*template file*

    {attr target=$obj class="active active:this-is-active status crap" href="public_url"}
    > class="is-active this-is-active pending" href="http://example.com"

### Options

There are a few options you can pass in to customize the output of the generated attributes string.

#### enclose

*default:* "

    {attr target=$obj class="active" enclose="'"}
    > class='is-active'

#### delimiter

*default:* " " (single space)

    {attr target=$obj class="active" href="public_url" delimiter="\n"}
    > class="is-active"\nhref="http://example.com"

#### sort

*default:* false

    {attr target=$obj href="public_url" class="active" sort=true}
    > class="is-active" href="http://example.com"