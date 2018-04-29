<?php

declare(strict_types=1);

/*
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Max107\Component\Parameters;

class Parameters implements \IteratorAggregate, \Countable
{
    use ParametersTrait;

    protected $parameters = [];

    /**
     * SettingParameterBag constructor.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters = [])
    {
        $this->parameters = $parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $key, $defaultValue = null)
    {
        return array_key_exists($key, $this->parameters) ? $this->parameters[$key] : $defaultValue;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->parameters);
    }
}
