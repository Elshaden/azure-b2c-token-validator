# Azure B2C AD Token Validator

This app will validate the Azure User Token , A JWT contains three segments, which are separated by the . character. The first segment is known as the header, the second as the body, and the third as the signature. The signature segment can be used to validate the authenticity of the token so that it can be trusted by your app.

Tokens issued by Azure AD are signed using industry standard asymmetric encryption algorithms, such as RS256. The header of the JWT contains information about the key and encryption method used to sign the token:

### This app will validate :
>1 The claim itself. to ensure that the claim is authenticated and matches your Azure B2C AD configuratiion

>2 The Token JWT Signature as All Azure proved tokens are signed, you need to authenticate the signiture to ensure the origin of the toke is Microsoft Azure AD.

##Usage
#### you need to send by POST:
 
    url = the location of your applicatio ninstallation


    "headers": {
    "Accept": "application/json",
    "Content-Type": "application/x-www-form-urlencoded"

            },

   
#### Parameters:

        "policy_name": "Your Policy Name that You Set Up In Azure B2C AD",
        "client_id": "Your Client Id",
        "tenant": "The Tenant Name",
        "token":  "The Token You want to Validate"

###Response 
#### Success   Http status  Code = 200
    
    {
    "token": "valid"
    }

 
#### Failed Http status Code = 400

    {
    "token": "Not valid"
    }

    

## Contributing

Thank you for considering contributing !

## Security Vulnerabilities

If you discover a security vulnerability within this application , Report in the issues section.

## License

 open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
