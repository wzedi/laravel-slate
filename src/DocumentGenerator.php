<?php

namespace CadreWorks\LaravelSlate;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Closure;
use Log;

class DocumentGenerator
{
    private function renderParam($name, $value)
    {
        $result = "";

        if (is_object($value))
        {
            $value = (array)$value;
        }

        if (is_array($value))
        {
            foreach ($value as $inner_name => $inner_value)
            {
                $result .= $this->renderParam($name . "[" . $inner_name . "]", $inner_value);
            }
        }
        else
        {
            $result = "-d \"$name=$value\" \n\\";
        }

        return $result;
    }

    /**
     * Generate tripit/slate documentation for a specific API request.
     *
     * @param Illuminate\Http\Request $request The request to document
     * @param 
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $method = $request->method();
        $path = $request->path();
        $response_content = $response->getOriginalContent();

        $username = isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : "";
        $password = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : "";
        $auth = "";
        if (!empty($username))
        {
            $auth = "\n-u $username:$password \\\n";
        }

        $params = "";
        foreach ($request->input() as $name => $value)
        {
            $params .= $this->renderParam($name, $value);
        }

        $slate_doc = <<<SLATE_DOC
            ##<Route name> 

            ```shell
            curl /$path \ $auth
                -X $method \
                $params
            ```

            ```PHP
            ```

            ```Java
            ```

            ```Ruby
            ```

            ```Python
            ```

            ```Node
            ```

            > The above command returns JSON structured like this:

            ```json
            $response_content
            ```
            
            <Description>

            ### HTTP Request

            `$method /$path`

SLATE_DOC;

        Log::debug($slate_doc);

        return $response;
    }
}
