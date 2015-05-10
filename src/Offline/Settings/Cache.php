<?php namespace Offline\Settings;

/**
 * Class Cache
 * @package Offline\Settings
 */
class Cache
{
    /**
     * Cached Settings
     *
     * @var array
     */
    protected $settings;


    /**
     * Constructor
     *
     * @param string $cacheFile
     */
    public function __construct()
    {
        $this->settings = $this->getAll();
    }

    /**
     * Sets a value
     *
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    public function set($key, $value)
    {
        $this->settings[$key] = $value;
        $this->store();

        return $value;
    }

    /**
     * Gets a value
     *
     * @param      $key
     * @param null $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return (array_key_exists($key, $this->settings) ? $this->settings[$key] : $default);
    }

    /**
     * Checks if $key is cached
     *
     * @param $key
     *
     * @return bool
     */
    public function hasKey($key)
    {
        return array_key_exists($key, $this->settings);
    }

    /**
     * Gets all cached settings
     *
     * @return array
     */
    public function getAll()
    {
        return \Cache::get('offline_persistent_settings', array());
    }

    /**
     * Stores all settings to the cache file
     *
     * @return void
     */
    private function store()
    {
        \Cache::forever('offline_persistent_settings', $this->settings);
    }

    /**
     * Removes a value
     *
     * @return void
     */
    public function forget($key)
    {
        if (array_key_exists($key, $this->settings)) {
            unset($this->settings[$key]);
        }
        $this->store();
    }

    /**
     * Removes all values
     *
     * @return void
     */
    public function flush()
    {
        \Cache::forget('offline_persistent_settings');
    }
}
