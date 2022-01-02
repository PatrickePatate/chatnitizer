# chatnitizer
Small PHP value sanitizer for me to quick sanitize values inside my project

## Usage
Refer to Tester.php<br/>
```php
$chatnitizer = new Chatnitizer("mode","data_to_sanitize");
```
where mode can be ``email, string, url, input, number, removehtml``<br /><br />
You can also *pipe* modes to proceed multi-sanitizing at once :
```php
$chatnitizer = new Chatnitizer("mode1|mode2|mode3|...","data_to_sanitize");
```