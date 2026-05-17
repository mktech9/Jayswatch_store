<div class="scrollToTop">
    <span class="arrow"><i class="ri-arrow-up-circle-fill fs-20"></i></span>
</div>
<div id="responsive-overlay"></div>

<script src="{{ $actual_url . '/admin_assets/js/jquery-3.7.1.min.js' }}"></script>

<script src="{{ $actual_url . '/admin_assets/libs/flatpickr/flatpickr.min.js' }}"></script>
<script src="{{ $actual_url . '/admin_assets/js/date&time_pickers.js' }}"></script>

<!-- Popper JS -->
<script src="{{ $actual_url . '/admin_assets/libs/@popperjs/core/umd/popper.min.js' }}"></script>

<!-- Bootstrap JS -->
<script src="{{ $actual_url . '/admin_assets/libs/bootstrap/js/bootstrap.bundle.min.js' }}"></script>

<!-- Defaultmenu JS -->
<script src="{{ $actual_url . '/admin_assets/js/defaultmenu.min.js' }}"></script>

<!-- -->
<script src="{{ $actual_url . '/admin_assets/js/sweetalert.js' }}"></script>

<!-- Node Waves JS -->
<script src="{{ $actual_url . '/admin_assets/libs/node-waves/waves.min.js' }}"></script>

<!-- Sticky JS -->
<script src="{{ $actual_url . '/admin_assets/js/sticky.js' }}"></script>

<!-- Simplebar JS -->
<script src="{{ $actual_url . '/admin_assets/libs/simplebar/simplebar.min.js' }}"></script>
<script src="{{ $actual_url . '/admin_assets/js/simplebar.js' }}"></script>

<!-- Color Picker JS -->
<script src="{{ $actual_url . '/admin_assets/libs/@simonwep/pickr/pickr.es5.min.js' }}"></script>

<!-- JSVector Maps -->
<script src="{{ $actual_url . '/admin_assets/libs/jsvectormap/js/jsvectormap.min.js' }}"></script>
<script src="{{ $actual_url . '/admin_assets/libs/jsvectormap/maps/world-merc.js' }}"></script>

<!-- Apex Charts -->
<script src="{{ $actual_url . '/admin_assets/libs/apexcharts/apexcharts.min.js' }}"></script>

<!-- Dashboard -->
<script src="{{ $actual_url . '/admin_assets/js/ecommerce-dashboard.js' }}"></script>

<!-- Custom -->
<script src="{{ $actual_url . '/admin_assets/js/custom-switcher.min.js' }}"></script>
<script src="{{ $actual_url . '/admin_assets/js/custom.js' }}"></script>

<script src="{{ $actual_url . '/admin_assets/js/validation.js' }}"></script>
<script src="{{ $actual_url . '/admin_assets/js/Toasts.js' }}"></script>
<script src="{{ $actual_url . '/admin_assets/js/iziToast.min.js' }}"></script>

<!-- Datatables -->
<script src="{{ $actual_url . '/admin_assets/libs/datatables/jquery.dataTables.min.js' }}"></script>
<script src="{{ $actual_url . '/admin_assets/libs/datatables/dataTables.bootstrap5.min.js' }}"></script>
<script src="{{ $actual_url . '/admin_assets/libs/datatables/dataTables.responsive.min.js' }}"></script>
<script src="{{ $actual_url . '/admin_assets/libs/datatables/dataTables.buttons.min.js' }}"></script>
<script src="{{ $actual_url . '/admin_assets/libs/datatables/buttons.print.min.js' }}"></script>
<script src="{{ $actual_url . '/admin_assets/libs/datatables/pdfmake.min.js' }}"></script>
<script src="{{ $actual_url . '/admin_assets/libs/datatables/vfs_fonts.js' }}"></script>
<script src="{{ $actual_url . '/admin_assets/libs/datatables/buttons.html5.min.js' }}"></script>
<script src="{{ $actual_url . '/admin_assets/libs/datatables/jszip.min.js' }}"></script>
<script src="{{ $actual_url . '/admin_assets/libs/datatables/buttons.colVis.min.js' }}"></script>

<script src="{{ $actual_url . '/admin_assets/js/datatables.js' }}"></script>

<!-- Select2 -->
<script src="{{ $actual_url . '/admin_assets/js/select2.min.js' }}"></script>

<!-- Quill -->
<script src="{{ $actual_url . '/admin_assets/libs/quill/quill.min.js' }}"></script>

<!-- Filepond -->
<script src="{{ $actual_url . '/admin_assets/libs/filepond/filepond.min.js' }}"></script>
<script
    src="{{ $actual_url . '/admin_assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js' }}">
</script>
<script
    src="{{ $actual_url . '/admin_assets/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js' }}">
</script>
<script
    src="{{ $actual_url . '/admin_assets/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js' }}">
</script>
<script src="{{ $actual_url . '/admin_assets/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js' }}">
</script>
<script src="{{ $actual_url . '/admin_assets/libs/filepond-plugin-image-edit/filepond-plugin-image-edit.min.js' }}">
</script>
<script
    src="{{ $actual_url . '/admin_assets/libs/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.min.js' }}">
</script>
<script src="{{ $actual_url . '/admin_assets/libs/filepond-plugin-image-crop/filepond-plugin-image-crop.min.js' }}">
</script>
<script
    src="{{ $actual_url . '/admin_assets/libs/filepond-plugin-image-resize/filepond-plugin-image-resize.min.js' }}">
</script>
<script
    src="{{ $actual_url . '/admin_assets/libs/filepond-plugin-image-transform/filepond-plugin-image-transform.min.js' }}">
</script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js">
</script>
<script>
    function indianFormat(num) {
        num = parseFloat(num) || 0; // ✅ Force Number

        return num.toLocaleString("en-IN", {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function numberToWords(num) {
        const ones = ["", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine"];
        const tens = ["", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eighty", "Ninety"];
        const teens = ["Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen",
            "Nineteen"
        ];

        function convertBelowThousand(n) {
            let str = "";

            if (n >= 100) {
                str += ones[Math.floor(n / 100)] + " Hundred ";
                n %= 100;
            }

            if (n >= 10 && n < 20) {
                str += teens[n - 10] + " ";
            } else {
                str += tens[Math.floor(n / 10)] + " ";
                str += ones[n % 10] + " ";
            }

            return str.trim();
        }

        if (num === 0) return "Zero";

        let result = "";

        if (num >= 10000000) {
            result += convertBelowThousand(Math.floor(num / 10000000)) + " Crore ";
            num %= 10000000;
        }

        if (num >= 100000) {
            result += convertBelowThousand(Math.floor(num / 100000)) + " Lakh ";
            num %= 100000;
        }

        if (num >= 1000) {
            result += convertBelowThousand(Math.floor(num / 1000)) + " Thousand ";
            num %= 1000;
        }

        if (num > 0) {
            result += convertBelowThousand(num);
        }

        return result.trim() + " Only";
    }
</script>
