<?php

namespace App\Http\Controllers;

use Validator;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Admin;

class InstallController extends Controller
{
    /**
     * Display the installer index page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('installer.license');
    }

    /**
     * Validate if terms it agree
     *
     * @return \Illuminate\Http\Response
     */
    public function agreeTerms(Request $request)
    {
        $request->validate([
		    'terms' => 'required',
		]);

		return redirect('/install/requirements');
    }

    /**
     * Display the requirements page.
     *
     * @return \Illuminate\Http\Response
     */
    public function requirements()
    {
        $phpSupportInfo = $this->checkPHPversion('7.0.0');

        $requirements = $this->check(array(
        	'php' => [
	            'openssl',
	            'pdo',
	            'mbstring',
	            'tokenizer',
	            'JSON',
	            'cURL',
	        ],
	        'apache' => [
	            'mod_rewrite',
	        ]
        ));

        return view('installer.requirements', compact('requirements', 'phpSupportInfo'));
    }


    /**
     * Display the requirements page.
     *
     * @return \Illuminate\Http\Response
     */
    public function information()
    {
        return view('installer.information');
    }

    /**
     * Validate if terms it agree
     *
     * @return \Illuminate\Http\Response
     */
    public function setWebInformation(Request $request)
    {
        $validator = Validator::make($request->all(), [
        	'name' => 'required',
			'category' => 'required',
			'language' => 'required',
			'country' => 'required',
			'sign' => 'required'
        ]);

        if (!$validator->fails()) {
        	$client = new Client(['base_uri' => 'http://localhost/webx/public/api/']);
        	switch ($request->sign) {
        		case 'sign-up':
        			$response = $client->post('sign-up', [ 'json' => [
			    		'firstname' => $request->firstname,
						'lastname' => $request->lastname,
						'email' => $request->email,
						'password' => $request->password,
						'password_confirmation' => $request->confirm_password,
			    	]]);
			    	$contents = json_decode($response->getBody()->getContents(), true);

			    	$this->setEnv('APP_ADMIN_USER', json_encode(array(
			    		'firstname' => $request->firstname,
						'lastname' => $request->lastname,
						'email' => $request->email,
						'password' => $request->password,
			    	)));

        			break;
        		
        		case 'sign-in':
        			
        			break;
        	}
        	if (is_null($contents['errors'])) {
	    		return redirect('/install/configuration');   
	    	}else{
	    		foreach ($contents['errors'] as $key => $error) {
	    			$validator->errors()->add($key, $error[0]);
	    		}
	    	}       
        }

        return back()->withErrors($validator)->withInput($request->input());


    }


    /**
     * Display the requirements page.
     *
     * @return \Illuminate\Http\Response
     */
    public function configuration()
    {
        return view('installer.configuration');
    }

    /**
     * Validate if terms it agree
     *
     * @return \Illuminate\Http\Response
     */
    public function setConfiguration(Request $request)
    {
        $validator = Validator::make($request->all(), [
			'connection' => 'required|string',
			'name' => 'required|string',
			'host' => 'required|string',
			'port' => 'required|integer',
			'user' => 'required|string',
        ]);

        if (!$validator->fails()) {

        	$data = array(
        		'APP_NAME' => $request->name,
        		'DB_CONNECTION' => $request->connection,
        		'DB_HOST' => $request->host,
        		'DB_PORT' => $request->port,
        		'DB_DATABASE' => $request->name,
        		'DB_USERNAME' => $request->user,
        		'DB_PASSWORD' => (isset($request->password) && is_null($request->password)) ? $request->password : '',

        	);

        	foreach ($data as $key => $value) {
        		$this->setEnv($key, $value);
        	}

	        return redirect('/install/finish'); 

        }

        return back()->withErrors($validator)->withInput($request->input());

    }
    

    /**
     * Display the requirements page.
     *
     * @return \Illuminate\Http\Response
     */
    public function finish()
    {
        return view('installer.finish');
    }
    
    public function ajaxProcessSetConfiguration(Request $request)
    {
    	if (isset($request->config) && !is_null($request->config)) {
    		try{
    			switch ($request->config) {
	    			case 'initial':
	    				Artisan::call('migrate:fresh', array('--force' => true));
	    				break;
	    			
	    			case 'setvalues':
	    				Artisan::call('db:seed', array('--force' => true));
	    				break;

	    			case 'mainuser':
	    				$user = json_decode(env('APP_ADMIN_USER'));
	 
	    				Admin::create([
				            'firstname' => $user->firstname,
				            'lastname' => $user->lastname,
				            'email' => $user->email,
				            'password' => bcrypt($user->password),
				            'is_admin' => 2,
				            'group_id' => 1
				        ]);

	    				break;

	    			default:
	    				# code...
	    				break;
	    		}

	    		return ['status' => 'success', 'message' => 'Successful configuration'];
    		}catch(Exception $e){
    			return json_encode($e);
    		}
    	}
    	
    	return ['status' => 'error', 'message' => 'Error'];
    }
    

    /**
     * Check PHP version requirement.
     *
     * @return array
     */
    public function checkPHPversion(string $minPhpVersion = null)
    {
        $minVersionPhp = $minPhpVersion;
        $currentPhpVersion = $this->getPhpVersionInfo();
        $supported = false;

        if ($minPhpVersion == null) {
            $minVersionPhp = '7.0.0';
        }

        if (version_compare($currentPhpVersion['version'], $minVersionPhp) >= 0) {
            $supported = true;
        }

        $phpStatus = [
            'full' => $currentPhpVersion['full'],
            'current' => $currentPhpVersion['version'],
            'minimum' => $minVersionPhp,
            'supported' => $supported
        ];

        return $phpStatus;
    }

     /**
     * Get current Php version information
     *
     * @return array
     */
    private static function getPhpVersionInfo()
    {
        $currentVersionFull = PHP_VERSION;
        preg_match("#^\d+(\.\d+)*#", $currentVersionFull, $filtered);
        $currentVersion = $filtered[0];

        return [
            'full' => $currentVersionFull,
            'version' => $currentVersion
        ];
    }

    /**
     * Check for the server requirements.
     *
     * @param array $requirements
     * @return array
     */
    public function check(array $requirements)
    {
        $results = [];

        foreach($requirements as $type => $requirement)
        {
            switch ($type) {
                // check php requirements
                case 'php':
                    foreach($requirements[$type] as $requirement)
                    {
                        $results['requirements'][$type][$requirement] = true;

                        if(!extension_loaded($requirement))
                        {
                            $results['requirements'][$type][$requirement] = false;

                            $results['errors'] = true;
                        }
                    }
                    break;
                // check apache requirements
                case 'apache':
                    foreach ($requirements[$type] as $requirement) {
                        // if function doesn't exist we can't check apache modules
                        if(function_exists('apache_get_modules'))
                        {
                            $results['requirements'][$type][$requirement] = true;

                            if(!in_array($requirement,apache_get_modules()))
                            {
                                $results['requirements'][$type][$requirement] = false;

                                $results['errors'] = true;
                            }
                        }
                    }
                    break;
            }
        }

        return $results;
    }


    protected function setEnv($name, $value)
	{
	    $path = base_path('.env');
	    if (file_exists($path)) {
	    	try {
	    		file_put_contents($path, str_replace(
		            $name . '=' . env($name), $name . '=' . $value, file_get_contents($path)
		        ));
	        }
	        catch(Exception $e) {
	            dd($e);
	        }
	        
	    }
	}

}
