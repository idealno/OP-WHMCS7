<?php
namespace OpenProvider\WhmcsHelpers;
use WHMCS\Database\Capsule;

/**
 * Manage the Registrar data
 *
 * @package default
 * @license  Licensed to OpenProvider by Yourwebhoster.eu
 **/
class Registrar
{
    /**
     * Holds the registrar data.
     *
     * @var array
     */
    public static $data;

	/**
	 * Get the login 
	 *
	 * @return array ['registrar_parameters']
	 **/
	public static function get_login_data($registrar = 'openprovider')
	{
		$registrar_raw_data = Capsule::table('tblregistrars')
                ->where('registrar', $registrar)
                ->get();

        if(empty($registrar_raw_data))
        	throw \Exception('Registrar not found');

        $return_data = [];

        foreach($registrar_raw_data as $data)
        {
        	$return_data [ $data->setting ] = Crypt::decrypt($data->value);
        }

        self::$data = $return_data;

        return $return_data;
	}

    /**
     * Return the
     *
     * @param $key
     * @return mixed
     */
    public static function get($key)
    {
        if(empty(self::$data))
            self::get_login_data();

        return self::$data[$key];
	}
} // END class Registrar