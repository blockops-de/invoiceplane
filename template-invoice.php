<!DOCTYPE html>
<html lang="<?php _trans('cldr'); ?>">
    <head>
        <meta charset="utf-8">
        <title><?php _trans('invoice'); ?></title>
        <style>
            .clearfix:after {
                content: "";
                display: table;
                clear: both
            }

            a {
                color: #375bc8;
                text-decoration: underline
            }

            body {
                position: relative;
                width: 21cm;
                height: 29.7cm;
                margin: 0 auto;
                color: #3A3A3A;
                background: #FFFFFF;
                font-size: 12x
            }

            header {
                padding: 5px 0;
                margin-bottom: 30px
            }

            #logo {
                text-align: right;
                margin-bottom: 10px
            }

            #invoice-logo {
                max-height: 125px;
                text-align: right
            }

            .invoice-title {
                color: #375bc8;
                font-size: 2em;
                line-height: 1.4em;
                font-weight: normal;
                margin: 5px 0
            }

            #company {
                float: right;
                text-align: right;
                width: 40%
            }

            #client {
                float: left;
                width: 55%;
                margin-right: 5%
            }

            .invoice-details {
                text-align: right
            }

            .invoice-details table {
                border-collapse: collapse;
                border-spacing: 0;
                text-align: right;
                width: 40%;
                margin: 0 0 0 auto;
                font-size: 12px
            }

            .invoice-details table td {
                width: auto;
                margin: 0;
                padding: 0 0 0.2em 0
            }

            table.item-table {
                width: 100%;
                border-collapse: collapse;
                border-spacing: 0;
                margin-bottom: 0px;
                font-size: 12px
            }

            table.item-table tr:nth-child(2n-1) td {
                background: #F5F5F5
            }
            table.item-table th {
                padding: 5px 15px;
                border-bottom: 1px solid #606060;
                white-space: nowrap;
                text-align: left
            }

            table.item-table th.text-right {
                text-align: right
            }

            table.item-table td {
                padding: 5px 15px
            }

            table.item-table .invoice-sums {
                text-align: right
            }

            table.invoice-qr-code-table {
                width: 100%;
                line-height: 1.4;
                font-size: 14px
            }

            footer {
                position: absolute;
                bottom: 0;
                height: 100px;
                padding: 0;
                border-top: 2px solid #878686;
                width: 21cm;
            }

            footer table {
                width: 100%;
                border-collapse: collapse;
            }

            footer td {
                padding: 0;
                font-size: 10pt;
                line-height: 1;
            }

            .text-right {
                text-align: right
            }

            .text-red {
                color: #ea5340
            }

            .text-green {
                color: #77b632
            }

        </style>
    </head>
    <body>
        <header class="clearfix">
            <div id="logo">
                <?php echo invoice_logo_pdf(); ?>
            </div>

            <div id="client">
                <div>
                    <b><?php _htmlsc(format_client($invoice)); ?></b>
                </div>
                <?php if ($invoice->client_vat_id) {
                echo '<div>' . trans('vat_id_short') . ': ' . $invoice->client_vat_id . '</div>';
                }
                if ($invoice->client_tax_code) {
                echo '<div>' . trans('tax_code_short') . ': ' . $invoice->client_tax_code . '</div>';
                }
                if ($invoice->client_address_1) {
                echo '<div>' . htmlsc($invoice->client_address_1) . '</div>';
                }
                if ($invoice->client_address_2) {
                echo '<div>' . htmlsc($invoice->client_address_2) . '</div>';
                }
                if ($invoice->client_city || $invoice->client_state || $invoice->client_zip) {
                echo '<div>';
                    if ($invoice->client_city) {
                    echo htmlsc($invoice->client_city) . ' ';
                    }
                    if ($invoice->client_state) {
                    echo htmlsc($invoice->client_state) . ' ';
                    }
                    if ($invoice->client_zip) {
                    echo htmlsc($invoice->client_zip);
                    }
                    echo '</div>';
                }
                if ($invoice->client_country) {
                echo '<div>' . get_country_name(trans('cldr'), $invoice->client_country) . '</div>';
                }

                echo '<br/>';

                if ($invoice->client_phone) {
                echo '<div>' . trans('phone_abbr') . ': ' . htmlsc($invoice->client_phone) . '</div>';
                } ?>

            </div>
            <div id="company">
                <div><b><?php _htmlsc($invoice->user_name); ?></b></div>
                <?php if ($invoice->user_vat_id) {
                echo '<div>' . trans('vat_id_short') . ': ' . $invoice->user_vat_id . '</div>';
                }
                if ($invoice->user_tax_code) {
                echo '<div>' . trans('tax_code_short') . ': ' . $invoice->user_tax_code . '</div>';
                }
                if ($invoice->user_address_1) {
                echo '<div>' . htmlsc($invoice->user_address_1) . '</div>';
                }
                if ($invoice->user_address_2) {
                echo '<div>' . htmlsc($invoice->user_address_2) . '</div>';
                }
                if ($invoice->user_city || $invoice->user_state || $invoice->user_zip) {
                echo '<div>';
                    if ($invoice->user_city) {
                    echo htmlsc($invoice->user_city) . ' ';
                    }
                    if ($invoice->user_state) {
                    echo htmlsc($invoice->user_state) . ' ';
                    }
                    if ($invoice->user_zip) {
                    echo htmlsc($invoice->user_zip);
                    }
                    echo '</div>';
                }
                if ($invoice->user_country) {
                echo '<div>' . get_country_name(trans('cldr'), $invoice->user_country) . '</div>';
                }

                echo '<br/>';

                if ($invoice->user_phone) {
                echo '<div>' . trans('phone_abbr') . ': ' . htmlsc($invoice->user_phone) . '</div>';
                }
                if ($invoice->user_fax) {
                echo '<div>' . trans('fax_abbr') . ': ' . htmlsc($invoice->user_fax) . '</div>';
                }
                ?>
            </div>

        </header>

        <main>

            <div class="invoice-details clearfix">
                <table>
                    <tr>
                        <td><?php echo trans('invoice_date') . ':'; ?></td>
                        <td><?php echo date_from_mysql($invoice->invoice_date_created, true); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo trans('due_date') . ': '; ?></td>
                        <td><?php echo date_from_mysql($invoice->invoice_date_due, true); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo trans('amount_due') . ': '; ?></td>
                        <td><?php echo format_currency($invoice->invoice_balance); ?></td>
                    </tr>
                    <?php if ($payment_method): ?>
                    <tr>
                        <td><?php echo trans('payment_method') . ': '; ?></td>
                        <td><?php _htmlsc($payment_method->payment_method_name); ?></td>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>

            <h1 class="invoice-title"><?php echo trans('invoice') . ' ' . $invoice->invoice_number; ?></h1>

            <table class="item-table">
                <thead>
                    <tr>
                        <th class="item-name"><?php _trans('item'); ?></th>
                        <th class="item-desc"><?php _trans('description'); ?></th>
                        <th class="item-amount text-right"><?php _trans('qty'); ?></th>
                        <th class="item-price text-right"><?php _trans('price'); ?></th>
                        <?php if ($show_item_discounts) : ?>
                        <th class="item-discount text-right"><?php _trans('discount'); ?></th>
                        <?php endif; ?>
                        <th class="item-total text-right"><?php _trans('total'); ?></th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    foreach ($items as $item) { ?>
                    <tr>
                        <td><?php _htmlsc($item->item_name); ?></td>
                        <td><?php echo nl2br(htmlsc($item->item_description)); ?></td>
                        <td class="text-right">
                            <?php echo format_amount($item->item_quantity); ?>
                            <?php if ($item->item_product_unit) : ?>
                            <br>
                            <small><?php _htmlsc($item->item_product_unit); ?></small>
                            <?php endif; ?>
                        </td>
                        <td class="text-right">
                            <?php echo format_currency($item->item_price); ?>
                        </td>
                        <?php if ($show_item_discounts) : ?>
                        <td class="text-right">
                            <?php echo format_currency($item->item_discount); ?>
                        </td>
                        <?php endif; ?>
                        <td class="text-right">
                            <?php echo format_currency($item->item_total); ?>
                        </td>
                    </tr>
                    <?php } ?>

                </tbody>
                <tbody class="invoice-sums">

                    <tr>
                        <td <?php echo($show_item_discounts ? 'colspan="5"' : 'colspan="4"'); ?> class="text-right">
                            <?php _trans('subtotal'); ?>
                        </td>
                        <td class="text-right"><?php echo format_currency($invoice->invoice_item_subtotal); ?></td>
                    </tr>

                    <?php if ($invoice->invoice_item_tax_total > 0) { ?>
                    <tr>
                        <td <?php echo($show_item_discounts ? 'colspan="5"' : 'colspan="4"'); ?> class="text-right">
                            <?php _trans('item_tax'); ?>
                        </td>
                        <td class="text-right">
                            <?php echo format_currency($invoice->invoice_item_tax_total); ?>
                        </td>
                    </tr>
                    <?php } ?>


                    <?php foreach ($invoice_tax_rates as $invoice_tax_rate) : ?>
                    <tr>
                        <td <?php echo($show_item_discounts ? 'colspan="5"' : 'colspan="4"'); ?> class="text-right">
                            <?php echo htmlsc($invoice_tax_rate->invoice_tax_rate_name) . ' (' . format_amount($invoice_tax_rat
                            e->invoice_tax_rate_percent) . '%)'; ?>
                        </td>
                        <td class="text-right">
                            <?php echo format_currency($invoice_tax_rate->invoice_tax_rate_amount); ?>
                        </td>
                    </tr>
                    <?php endforeach ?>

                    <?php if ($invoice->invoice_discount_percent != '0.00') : ?>
                    <tr>
                        <td <?php echo($show_item_discounts ? 'colspan="5"' : 'colspan="4"'); ?> class="text-right">
                            <?php _trans('discount'); ?>
                        </td>
                        <td class="text-right">
                            <?php echo format_amount($invoice->invoice_discount_percent); ?>%
                        </td>
                    </tr>
                    <?php endif; ?>
                    <?php if ($invoice->invoice_discount_amount != '0.00') : ?>
                    <tr>
                        <td <?php echo($show_item_discounts ? 'colspan="5"' : 'colspan="4"'); ?> class="text-right">
                            <?php _trans('discount'); ?>
                        </td>
                        <td class="text-right">
                            <?php echo format_currency($invoice->invoice_discount_amount); ?>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <tr>
                        <td <?php echo($show_item_discounts ? 'colspan="5"' : 'colspan="4"'); ?> class="text-right">
                            <b><?php _trans('total'); ?></b>
                        </td>
                        <td class="text-right">
                            <b><?php echo format_currency($invoice->invoice_total); ?></b>
                        </td>
                    </tr>
                    <tr>
                        <td <?php echo($show_item_discounts ? 'colspan="5"' : 'colspan="4"'); ?> class="text-right">
                            <?php _trans('paid'); ?>
                        </td>
                        <td class="text-right">
                            <?php echo format_currency($invoice->invoice_paid); ?>
                        </td>
                    </tr>
                    <tr>
                        <td <?php echo($show_item_discounts ? 'colspan="5"' : 'colspan="4"'); ?> class="text-right">
                            <b><?php _trans('balance'); ?></b>
                        </td>
                        <td class="text-right">
                            <b><?php echo format_currency($invoice->invoice_balance); ?></b>
                        </td>
                    </tr>
                </tbody>
            </table>

            <?php if ($invoice->invoice_terms) : ?>
            <div class="notes">
                <b><?php _trans('terms'); ?></b><br/>
                <?php echo nl2br(htmlsc($invoice->invoice_terms)); ?>
            </div>
            <?php endif; ?>
        </main>

        <footer>
            <table>
                <tr>
                    <td><b>Blockchain Development GmbH</b></td>
                    <td>Ust.IdNr.: DE314877786</td>
                    <td><b>Volksbank Bocholt eG</b></td>
                </tr>
                <tr>
                    <td>Am Weichselgarten 7</td>
                    <td>Reg. HRB 16563 - Fürth (Bayern)</td>
                    <td><b>DE05 4286 0003 0276 8005 00</b></td>
                </tr>
                <tr>
                    <td>91058 Erlangen</td>
                    <td></td>
                    <td><b>GENODEM1BOH</b></td>
                </tr>
            </table>
        </footer>

    </body>
</html>
