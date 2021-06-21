<?php


namespace App\Actions\Azure;



// Decodes the data array and returns the value of "claim"
function getClaim($claim, $data)
{
    try {
        $data_array = json_decode($data, true);
        return $data_array[$claim];
    } catch (\Exception $e) {
        abort(400, 'Not Valid Token');
    }

}

class EndpointHandler
{
    private $metadata = "";
    protected $request;
    private $Claim;

    public function __construct($request)
    {
        $this->getMetadata($request);
        $this->Config = $this->Settings($request);
        $this->request = $request;
    }

    // Fetches the data at an endpoint using a HTTP GET request
    public function getEndpointData($uri)
    {
        try {
            return file_get_contents($uri);
        } catch (\Exception $e) {
            abort(400, 'Not Valid Token');
        }
    }



    // Given a B2C policy name, constructs the metadata endpoint
    // and fetches the metadata from that endpoint
    public function getMetadata($request)
    {


        $metadata_endpoint_begin = "https://" . $request->tenant . ".b2clogin.com/" .
            $request->tenant .
            '.onmicrosoft.com/v2.0/.well-known/openid-configuration?p=';

        $metadata_endpoint = $metadata_endpoint_begin . $request->policy_name;
        //   return $this->getEndpointData($metadata_endpoint_begin);
        $this->metadata = $this->getEndpointData($metadata_endpoint);
    }

    // Returns the value of the issuer claim from the metadata
    public function getIssuer()
    {

        $iss = getClaim("issuer", $this->metadata);
        return $iss;
    }

    // Returns the value of the jwks_uri claim from the metadata
    public function getJwksUri()
    {
        $jwks_uri = getClaim("jwks_uri", $this->metadata);
        return $jwks_uri;
    }

    // Returns the data at the jwks_uri page
    public function getJwksUriData()
    {
        $jwks_uri = $this->getJwksUri();
        $key_data = $this->getEndpointData($jwks_uri);
        return $key_data;
    }


    private function Settings($request)
    {
        return [
            'client_id' => $request->client_id,
            'scope' => $request->scope ?? 'openid',
            'response_type' => 'id_token',
            'tenant' => $request->tenant,
            'policy_name' => $request->policy_name,
        ];
    }
}
