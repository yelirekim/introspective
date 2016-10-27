# Introspective

This library aims to provide a convenient and efficient way to extract structured,
arbitrary class metadata from any given PHP codebase.  The main driver behind
features is supplying this information to code completion plugins for various
editors.

This package is in super early development and will make backwards incompatible
changes frequently.

# Usage

To get an autocomplete server running, you should need to do only the following:

```shell
git clone https://github.com/yelirekim/introspective.git
cd introspective
./bin/serve --address="yourserver.com" --port=8080 \
    --bootstrap="/path/to/yourbootstrap.php"
```
