<div class="text-center">
    <h5>Page Authority is:</h5>
    <h3><strong><?php echo @$mozAPI->pa; ?></strong></h3>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Domain</th>
                <th>Domain Authority</th>
                <th>Page Authority</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo $domain; ?></td>
                <td><?php echo @$mozAPI->da; ?></td>
                <td><?php echo @$mozAPI->pa; ?></td>
            </tr>
        </tbody>
    </table>
</div>