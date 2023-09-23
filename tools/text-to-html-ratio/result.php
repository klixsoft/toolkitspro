<div class="text-center">
    <h5>Code to Text Ratio is</h5>
    <h3 class="text-<?php echo $per >= 15 ? 'success' : 'warning'; ?>"><strong><?php echo round($per, 2); ?>%</strong></h3>

    <?php if( $per >= 15 ): ?>
    <em>That's good, nothing to worry about</em>
    <?php else: ?>
    <em>That's a bit low. Can you remove unneeded code?</em> 
    <?php endif; ?>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Page Size</th>
                <th>Code Size</th>
                <th>Text Size</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo format_size($orglen); ?></td>
                <td><?php echo format_size($codelen); ?></td>
                <td><?php echo format_size($textlen); ?></td>
            </tr>
        </tbody>
    </table>
</div>