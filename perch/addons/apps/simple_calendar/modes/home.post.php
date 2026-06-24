<?php

    echo $HTML->side_panel_start();
    echo $HTML->side_panel_end();

    echo $HTML->title_panel([
        'heading' => $Lang->get('Sales Summary'),
    ], $CurrentUser);

    echo $HTML->main_panel_start();

    include('_subnav.php');

?>

    <div class="sales-month-nav" style="display:flex;align-items:center;justify-content:space-between;max-width:600px;margin:1.5rem 0;">
        <a class="button" href="<?php echo $HTML->encode($prevLink); ?>">&larr; <?php echo $Lang->get('Previous'); ?></a>
        <h2 style="margin:0;text-align:center;"><?php echo $monthLabel; ?></h2>
        <a class="button" href="<?php echo $HTML->encode($nextLink); ?>"><?php echo $Lang->get('Next'); ?> &rarr;</a>
    </div>

    <table class="d" style="max-width:600px;">
        <thead>
            <tr>
                <th class="first">Unit</th>
                <th>Bookings</th>
                <th class="last">Sales</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach ($units as $unit) {
        $uid      = $unit['unitID'];
        $bookings = isset($salesMap[$uid]) ? (int) $salesMap[$uid]['bookings'] : 0;
        $total    = isset($salesMap[$uid]) ? (float) $salesMap[$uid]['total'] : 0;
?>
            <tr>
                <td><?php echo $HTML->encode($unit['name']); ?></td>
                <td><?php echo $bookings; ?></td>
                <td>&pound;<?php echo number_format($total, 2); ?></td>
            </tr>
<?php
    }
?>
        </tbody>
        <tfoot>
            <tr>
                <th class="first">Total</th>
                <th><?php echo (int) $grandBookings; ?></th>
                <th class="last">&pound;<?php echo number_format($grandTotal, 2); ?></th>
            </tr>
        </tfoot>
    </table>

<?php

    echo $HTML->main_panel_end();

?>
