<?

// EU-VAT check - partita-IVA
//  http://www.dontesta.it/blog/web-services/web-service-partite-iva-comunitarie/ (italian)
//  http://www1.agenziaentrate.it/servizi/vies/faq.htm (italian)

function GetVal( $sVar, $sDef = '' )
{
	if( isset( $_REQUEST[ $sVar ] ) )
	{
		return $_REQUEST[ $sVar ];
	}
	
	return $sDef;
}

$client = new SoapClient( 'http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl' );
$js = $client->checkVat( array(
	'countryCode' => GetVal( 'cc', 'IT' ),
	'vatNumber'   => GetVal( 'vat', '00146089990' )
) );

//echo( json_encode( $js ) );
//var_dump( $js );

?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"> 
        <meta name="robots" content="noindex, nofollow">
		<link rel="shortcut icon" href="favicon.ico">
		<title>IVA</title>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
        <style>
            * {
                font-size: 12px;
                font-family: 'Open Sans', sans-serif;
                margin-bottom: 0px;
            }
            
            table {
                margin: 0;
                text-align: left;
                border-collapse: collapse;
                border: 1px solid #aaaaaa;
            }

            tr:nth-child(even) {
                background: #eeeeee;
            }

            th, td {
                padding: 5px 10px;
            }

            th {
                border-bottom: 1px solid #aaaaaa;
            }
            			
            h3 {
				font-size:14px;
				margin-bottom:22px;
				color:#17469e;
			}
			
            .block {
                margin: 0;
                text-align: left;
				border-radius: 4px;
				border-collapse: collapse;
                border: 1px solid #aaaaaa;
				padding: 0px 15px 15px 15px;
            }
            
			form label,
            form input,
            form textarea { 
				border: solid 1px #aaaaaa;
				padding: 3px;
			}
			
            .button {
                background-color: #17469e !important;
                border-color: #17469e !important;
                font-weight: bold;
                padding: 10px 12px;
                min-width: 150px;
                color: #ffffff;
				border-radius: 4px;
            }
            
            .errorMsg {
				color: #cc0000;
				margin-bottom: 10px
			}
			
			a:link {
				text-decoration:none;
				color:#000;
			}
			
			a:visited {
				text-decoration:none;
				color:#000;
			}
			
			a:hover {
				text-decoration:underline;
				color:#000;
			}
			
			a:active {
				text-decoration:none;
				color:#000;
			}
        </style>
    </head>
    <body>
        <div class="block">
            <h3>Partita IVA (comunitaria):</h3>
            <form method="post">
	            <table>
					<tr>
						<td>Partita IVA:</td>
						<td><input type="text" name="vat" autocomplete="off" value="<?php echo( GetVal( 'vat', '01014850257' ) ); ?>"/></td>
		            </tr>
					<tr>
						<td>Paese (IT):</td>
						<td><input type="text" name="cc" autocomplete="off" value="<?php echo( GetVal( 'cc', 'IT' ) ); ?>"/></td>
		            </tr>
		            <?
			            if( isset( $js->requestDate ) )
			            {
							echo( '<tr><td>request date:</td>' );
							echo( '<td><b>' . $js->requestDate . '</b></td></tr>' );
			            }
			            if( isset( $js->valid ) )
			            {
							echo( '<tr><td>valid:</td>' );
							echo( '<td><b>' . $js->valid . '</b></td></tr>' );
			            }
			            if( isset( $js->name ) )
			            {
				            $js->name = str_replace( '!!', '- ', $js->name );
				            
							echo( '<tr><td>name:</td>' );
							echo( '<td><b>' . $js->name . '</b></td></tr>' );
			            }
			            if( isset( $js->address ) )
			            {
				            $js->address = str_replace( "\n", '<br />', $js->address );
				            $js->address = str_replace( "\r", '<br />', $js->address );
				            
							echo( '<tr><td>address:</td>' );
							echo( '<td><b>' . $js->address . '</b></td></tr>' );
			            }
			        ?>
	            </table><br />
                <input type="submit" class="button" name="Search" value="Search" />
            </form>
        </div>
    </body>
</html>
