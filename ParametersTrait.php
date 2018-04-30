<?php

declare(strict_types=1);

/*
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Max107\Component\Parameters;

trait ParametersTrait
{
    /**
     * @param string $key
     * @param null   $defaultValue
     *
     * @return mixed
     */
    abstract public function get(string $key, $defaultValue = null);

    /**
     * Returns the alphabetic characters of the parameter value.
     *
     * @param string $key     The parameter key
     * @param string $default The default value if the parameter key does not exist
     *
     * @return string The filtered value
     */
    public function getAlpha(string $key, $default = '')
    {
        return preg_replace('/[^[:alpha:]]/', '', $this->get($key, $default));
    }

    /**
     * Returns the alphabetic characters and digits of the parameter value.
     *
     * @param string $key     The parameter key
     * @param string $default The default value if the parameter key does not exist
     *
     * @return string The filtered value
     */
    public function getAlnum(string $key, $default = '')
    {
        return preg_replace('/[^[:alnum:]]/', '', $this->get($key, $default));
    }

    /**
     * Returns the digits of the parameter value.
     *
     * @param string $key     The parameter key
     * @param string $default The default value if the parameter key does not exist
     *
     * @return string The filtered value
     */
    public function getDigits(string $key, $default = '')
    {
        // we need to remove - and + because they're allowed in the filter
        return str_replace(['-', '+'], '', $this->filter($key, $default, FILTER_SANITIZE_NUMBER_INT));
    }

    /**
     * Returns the parameter value converted to integer.
     *
     * @param string $key     The parameter key
     * @param int    $default The default value if the parameter key does not exist
     *
     * @return int The filtered value
     */
    public function getInt(string $key, $default = 0)
    {
        return (int) $this->get($key, $default);
    }

    /**
     * Returns the parameter value converted to boolean.
     *
     * @param string $key     The parameter key
     * @param mixed  $default The default value if the parameter key does not exist
     *
     * @return bool The filtered value
     */
    public function getBoolean(string $key, $default = false)
    {
        return $this->filter($key, $default, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Returns the parameter value converted to float.
     *
     * @param string $key     The parameter key
     * @param mixed  $default The default value if the parameter key does not exist
     *
     * @return null|float The filtered value
     */
    public function getFloat(string $key, $default = 0.0): ?float
    {
        $value = $this->filter($key, $default, FILTER_VALIDATE_FLOAT);
        if (false === is_float($value)) {
            return $default;
        }

        return $value;
    }

    /**
     * Filter key.
     *
     * @param string $key     Key
     * @param mixed  $default Default = null
     * @param int    $filter  FILTER_* constant
     * @param mixed  $options Filter options
     *
     * @see http://php.net/manual/en/function.filter-var.php
     *
     * @return mixed
     */
    public function filter(string $key, $default = null, $filter = FILTER_DEFAULT, array $options = [])
    {
        $value = $this->get($key, $default);

        // Add a convenience check for arrays.
        if (is_array($value) && !isset($options['flags'])) {
            $options['flags'] = FILTER_REQUIRE_ARRAY;
        }

        return filter_var($value, $filter, $options);
    }
}
