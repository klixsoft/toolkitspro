<br />
<p><strong>Type 1 - Directory Type URL</strong></p>
<table class="table table-bordered">
    <tbody>
        <tr>
            <td><strong>Generated URL</strong></td>
            <td><?php echo $sht_url; ?></td>
        </tr>
        <tr>
            <td><strong>Example URL</strong></td>
            <td><?php echo $sht_ex_url; ?></td>
        </tr>
    </tbody>
</table>

<p>Create a .htaccess file with the code below<br/>
The .htaccess file needs to be placed in <?php echo extractHostname($url); ?></p>

<textarea rows="4" disabled class="form-control"><?php   echo $sht_data; ?></textarea>

<br />
<br />
<p><strong>Type 2 - Directory Type URL</strong></p>
<table class="table table-bordered">
    <tbody>
        <tr>
            <td><strong>Generated URL</strong></td>
            <td><?php echo $dht_url; ?></td>
        </tr>
        <tr>
            <td><strong>Example URL</strong></td>
            <td><?php echo $dht_ex_url; ?></td>
        </tr>
    </tbody>
</table>

<p>Create a .htaccess file with the code below<br/>
The .htaccess file needs to be placed in <?php echo extractHostname($url); ?></p>

<textarea rows="4" disabled class="form-control"><?php   echo $dht_data; ?></textarea>
