# Collection Class

The Collection class represents a collection of data with support for nested keys.

## Installation

You can install the Collection class via Composer:

```bash
composer require webdevcave/collections
```

## Usage

Instantiate the Collection class with an optional array of initial data:

```php
use WebdevCave\Collections\Collection;

$collection = new Collection([
    'user' => [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'address' => [
            'city' => 'New York',
            'country' => 'USA'
        ]
    ]
]);
```

Access nested data using dot notation:

```php
$city = $collection->get('user.address.city'); // Returns 'New York'
```

Check if a nested key exists:

```php
$hasCountry = $collection->has('user.address.country'); // Returns true
```

Set a value for a nested key:

```php
$collection->set('user.address.postal_code', '10001');
```

Delete a key and its value:

```php
$collection->delete('user.address.city');
```

Clear the collection:

```php
$collection->clear();
```

## Contributing

Bug reports, suggestions and pull requests are welcome on GitHub.

## License

The class is available as open source under the terms of the [MIT License](https://opensource.org/licenses/MIT).
