<section class="section section-page">
    <div class="container-xl">
        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                    <li class="breadcrumb-item active"><?= trans("earnings"); ?></li>
                </ol>
            </nav>
            <h1 class="page-title"><?= trans("earnings"); ?></h1>
            <div class="page-content">
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <?= loadView('earnings/_tabs'); ?>
                    </div>
                    <div class="col-sm-12 col-md-9">
                        <div class="d-flex justify-content-center gap-5 earnings-box-container">
                            <div class="earnings-box justify-content-between">
                                <div class="flex-column">
                                    <strong><?= user()->total_pageviews; ?></strong>
                                    <label><?= trans("total_pageviews"); ?></label>
                                </div>
                                <div class="flex-column">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="#4bc0c0" class="bi bi-bar-chart-fill" viewBox="0 0 16 16">
                                        <path d="M1 11a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3zm5-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1V2z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="earnings-box justify-content-between">
                                <div class="flex-column">
                                    <strong><?= priceFormatted(user()->balance); ?></strong>
                                    <label><?= trans("balance"); ?></label>
                                </div>
                                <div class="flex-column">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="#4bc0c0" class="bi bi-wallet-fill" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z"/>
                                        <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z"/>
                                        <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1H1z"/>
                                        <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 text-center">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">

                                <script src="<?= base_url('assets/vendor/chart/chart.min.js'); ?>"></script>
                                <script src="<?= base_url('assets/vendor/chart/utils.js'); ?>"></script>
                                <script src="<?= base_url('assets/vendor/chart/analyser.js'); ?>"></script>
                                <div class="content">
                                    <div style="min-height: 400px;">
                                        <canvas id="chart-2"></canvas>
                                    </div>
                                </div>
                                <div class="table-responsive table-earnings">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th scope="col"><?= trans("date"); ?></th>
                                            <th scope="col"><?= trans("pageviews"); ?></th>
                                            <th scope="col"><?= trans("earnings"); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (!empty($pageViewsCounts)):
                                            for ($i = 1; $i <= $numberOfDays; $i++):
                                                if ($i <= $today):
                                                    $earning = getEarningObjectByDay($i, $pageViewsCounts);
                                                    if (!empty($earning)):?>
                                                        <tr>
                                                            <td><?= date("M j, Y", strtotime($earning->date)); ?></td>
                                                            <td><?= $earning->count; ?></td>
                                                            <td><?= priceFormatted($earning->total_amount, getRewardPriceDecimal()); ?></td>
                                                        </tr>
                                                    <?php endif;
                                                endif;
                                            endfor;
                                        endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <script>
                                    var number_of_days = parseInt('<?= $numberOfDays; ?>');
                                    var presets = window.chartColors;
                                    var utils = Samples.utils;
                                    var inputs = {
                                        min: 0,
                                        max: 1,
                                        count: 8,
                                        decimals: 2,
                                        continuity: 1
                                    };

                                    function generateLabels(config) {
                                        var labels = [];
                                        var i;
                                        for (i = 1; i <= number_of_days; i++) {
                                            labels.push(i);
                                        }
                                        return labels;
                                    }

                                    var options = {
                                        maintainAspectRatio: false,
                                        spanGaps: false,
                                        elements: {
                                            line: {
                                                tension: 0.000001
                                            }
                                        },
                                        plugins: {
                                            filler: {
                                                propagate: false
                                            }
                                        },
                                        scales: {
                                            x: {
                                                ticks: {
                                                    autoSkip: false,
                                                    maxRotation: 0
                                                }
                                            },
                                            xAxes: [
                                                {
                                                    scaleLabel: {
                                                        display: true,
                                                        labelString: ''
                                                    }
                                                }
                                            ],
                                            yAxes: [
                                                {
                                                    ticks: {
                                                        beginAtZero: true,
                                                        callback: function (label, index, labels) {
                                                            return "<?= esc($generalSettings->currency_symbol); ?>" + label.toFixed(4);
                                                        }
                                                    }
                                                }
                                            ]
                                        },
                                        tooltips: {
                                            enabled: false
                                        },
                                        legend: {
                                            onClick: null
                                        }
                                    };
                                    [false, 'origin', 'start', 'end'].forEach(function (boundary, index) {
                                        // reset the random seed to generate the same data for all charts
                                        utils.srand(8);
                                        new Chart('chart-' + index, {
                                            type: 'line',
                                            data: {
                                                labels: generateLabels(),
                                                datasets: [{
                                                    backgroundColor: utils.transparentize(presets.green),
                                                    borderColor: presets.green,
                                                    data: [
                                                        <?php for ($i = 1; $i <= $numberOfDays; $i++) {
                                                        if ($i <= $today) {
                                                            if ($i != 1) {
                                                                echo ',';
                                                            }
                                                            $earning = getEarningObjectByDay($i, $pageViewsCounts);
                                                            if (!empty($earning)) {
                                                                if (!empty($earning->total_amount)) {
                                                                    echo number_format($earning->total_amount, getRewardPriceDecimal(), '.', '');
                                                                }
                                                            } else {
                                                                echo '0';
                                                            }
                                                        }
                                                    } ?>
                                                    ],
                                                    label: '<?= trans("earnings") ?>: <?= replaceMonthName(date("M Y"));?>',
                                                    fill: boundary
                                                }]
                                            },
                                            options: Chart.helpers.merge(options, {
                                                title: {
                                                    text: 'fill: ' + boundary,
                                                    display: false
                                                }
                                            })
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>