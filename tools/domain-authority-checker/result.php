<div class="text-center">
    <h5>Domain Authority is:</h5>
    <h3><strong><?php echo @$mozResponse->da; ?></strong></h3>

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
                <td><?php echo @$mozResponse->da; ?></td>
                <td><?php echo @$mozResponse->pa; ?></td>
            </tr>
        </tbody>
    </table>
</div>