<?php
$connection = oci_connect($username = 'jing',
                          $password = 'spring123456',
                          $connection_string = '//oracle.cise.ufl.edu/orcl');
$statement = oci_parse($connection, 'SELECT * FROM useraccount');
oci_execute($statement);

print "<table border='1'>\n";
while ($row = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS)) {
    print "<tr>\n";
    foreach ($row as $item) {
        print "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
    }
    print "</tr>\n";
}
print "</table>\n";


//
// VERY important to close Oracle Database Connections and free statements!
//
oci_free_statement($statement);
oci_close($connection);