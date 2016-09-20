<div class="footPart" id="mainFootPart">
<?php
	$allHeaders = getallheaders();
	if(array_key_exists("AuthUser", $allHeaders))
	{
		echo($allHeaders[AuthUser]);
	}
	else
	{
		echo("Disconnected");
	}
	echo("<br/>");

	// Assurez-vous que l'hôte est correct
	// et que vous avez un certificat valide
	$ldaphost = "sldap-bpi.bpi.fr";

	// Eléments d'authentification LDAP
	$ldaprdn  = 'ou=lecture,ou=applications,dc=bpi,dc=fr';	// DN ou RDN LDAP
	$ldappass = 'mio1eThe';					// Mot de passe associé

	// Connexion LDAP
	$ldapconn = ldap_connect($ldaphost) or die("Impossible de se connecter au serveur LDAP {$ldaphost}");

	if ($ldapconn)
	{
		// Connexion au serveur LDAP
		$ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);
		//$ldapbind = ldap_bind($ldapconn);

		// Vérification de l'authentification
		if ($ldapbind)
		{
			echo "Connexion LDAP réussie...";
		}
		else
		{
			echo "Connexion LDAP échouée...";
			echo "<br/>";
			echo ldap_error ($ldapconn);
		}
	}
	else
	{
		echo("Server LDAP non-trouvé.");
	}

echo("<br/>aa")
?>
</div>
