# Laravel Query

Query is a package that provides queries objects for your Laravel application.

## Installation

### 1: Require via composer

From the command line, run:

```
composer require xabou/query
```

Alternatively, you can put the following in your composer.json file:

```
{
    "require": {
        "xabou/query": "^0.5.0"
    }
}
```

### 2: Register Service Provider

Open `config/app.php` and append `providers` array with:

```
Xabou\Query\QueryServiceProvider::class
```

## Usage

### Create A Query

With the package now installed, a new artisan command is available.

```
php artisan make:query PopularUsersQuery
```

A 'Queries' directory will be created, if it doesn't already exist, within your app.
 
### Declare Query Body
 
Within the body method you can declare your query: 

```php
public static function body()
{
    return User::select(['user.username', 'user.id', 'user.verified', 'popularity_user.score'])
                 ->join('popularity_user', 'users.id', '=', 'popularity_user.user_id')
                 ->where('user.verified', 1)
                 ->with('avatar')
                 ->orderBy('popularity_user.score', 'DESC')
                 ->orderBy('user.username', 'ASC');
}
```

### Fetch Results

#### 1: Delegate to Eloquent Database Builder

You can call any method defined in Eloquent Database Builder by returning an instance of it, like above example.

```php

// Dynamic static method calls
PopularUsersQuery::first()

// or
PopularUsersQuery::get()

// Dynamic method calls
new PopularUsersQuery()->get()

```

#### 2: Execute query

Within the body method you can also execute your query.

```php
public static function body()
{
    return User::select(['user.username', 'user.id', 'user.verified', 'popularity_user.score'])
                 ->join('popularity_user', 'users.id', '=', 'popularity_user.user_id')
                 ->where('user.verified', 1)
                 ->with('avatar')
                 ->orderBy('popularity_user.score', 'DESC')
                 ->first();
}

```

Then simply call get method on Query.

```php

PopularUsersQuery::get()
```

**Note:** In this case get method serves as an alias to body method. It won't delegate to Eloquent Database Builder.

#### 3: Chain query

By returning the content of body you can continue chaining methods on Eloquent Database Builder.

```php

PopularUsersQuery::body()->where('age', '>', 25)->get();
```