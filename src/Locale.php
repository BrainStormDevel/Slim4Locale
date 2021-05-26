<?php

/*############################################
		   Locale Middleware part of
                 PerSeo CMS

        Copyright © 2019-2021 BrainStorm
   https://github.com/BrainStormDevel/perseo

*/############################################

namespace BrainStorm\Locale4Slim;

use Slim\App;
use Slim\Psr7\Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class Locale
{
    protected $app;
	protected $active;
	protected $languages;

    public function __construct(App $app, bool $active, array $languages)
    {
        $this->app = $app;
		$this->active = $active;
		$this->languages = $languages;
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
		$fulluri = (string) $request->getUri()->getPath();
		$basepath = (string) $this->app->getBasePath();
		$uri = (string) substr($fulluri, strlen($basepath));
		if (($request->getMethod() == 'GET') && ($this->active) && ($uri != '/')) {
			preg_match("/^\/([a-zA-Z]{2})\//",$uri,$matches);
			if (!empty($matches[1]) && in_array($matches[1], $this->languages)) {
				$fulluri = (string) $basepath . substr($uri, 3);
				$request = $request->withAttribute('locale', $matches[1]);
				$request = $request->withUri($request->getUri()->withPath($fulluri));
			}
			else {
				throw new \Slim\Exception\HttpNotFoundException($request);
			}
		}
        $response = $handler->handle($request);    
        return $response;
    }
}