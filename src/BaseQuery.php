<?php

namespace Xabou\Query;


use Illuminate\Database\Eloquent\Builder;

abstract class BaseQuery
{
    /**
     * Handle dynamic static method calls into instance of body method.
     *
     * @param  string $method
     * @param  array $parameters
     * @return mixed
     *
     */
    public static function __callStatic($method, $parameters)
    {
        $builder = (new static)->body();

        return call_user_func_array([$builder, $method], $parameters);
    }

    /**
     * Handle dynamic method calls into returned instance of body method.
     *
     * @param  string $method
     * @param  array $parameters
     * @return mixed
     *
     */
    public function __call($method, $parameters)
    {
        $builder = $this->body();

        return call_user_func_array([$builder, $method], $parameters);
    }

    /**
     * Execute the query.
     *
     * @return mixed
     *
     */
    public static function get()
    {
        $builder = call_user_func_array([new static, 'body'], func_get_args());
        if ($builder instanceof Builder) {
            return $builder->get();
        }

        return $builder;
    }
}
