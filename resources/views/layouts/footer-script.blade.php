<script src="{{ asset('backend/assets/js/core/jquery-3.7.1.min.js')}}"></script>
<script src="{{ asset('backend/assets/js/core/popper.min.js')}}"></script>
<script src="{{ asset('backend/assets/js/core/bootstrap.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<!-- jQuery Scrollbar -->
<script src="{{ asset('backend/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>

<!-- Chart JS -->
<script src="{{ asset('backend/assets/js/plugin/chart.js/chart.min.js')}}"></script>

<!-- jQuery Sparkline -->
<script src="{{ asset('backend/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js')}}"></script>

<!-- Chart Circle -->
<script src="{{ asset('backend/assets/js/plugin/chart-circle/circles.min.js')}}"></script>

<!-- Datatables -->
<script src="{{ asset('backend/assets/js/plugin/datatables/datatables.min.js')}}"></script>

<!-- Bootstrap Notify -->
<script src="{{ asset('backend/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js')}}"></script>

<!-- jQuery Vector Maps -->
<script src="{{ asset('backend/assets/js/plugin/jsvectormap/jsvectormap.min.js')}}"></script>
<script src="{{ asset('backend/assets/js/plugin/jsvectormap/world.js')}}"></script>

<!-- Sweet Alert -->
<script src="{{ asset('backend/assets/js/plugin/sweetalert/sweetalert.min.js')}}"></script>

<!-- Kaiadmin JS -->
<script src="{{ asset('backend/assets/js/kaiadmin.min.js')}}"></script>

<!-- Kaiadmin DEMO methods, don't include it in your project! -->
<script src="{{ asset('backend/assets/js/setting-demo.js')}}"></script>
<script src="{{ asset('backend/assets/js/demo.js')}}"></script>
<script src="{{ asset('backend/assets/js/select2.min.js')}}"></script>
<script>
  $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
    type: "line",
    height: "70",
    width: "100%",
    lineWidth: "2",
    lineColor: "#177dff",
    fillColor: "rgba(23, 125, 255, 0.14)",
  });

  $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
    type: "line",
    height: "70",
    width: "100%",
    lineWidth: "2",
    lineColor: "#f3545d",
    fillColor: "rgba(243, 84, 93, .14)",
  });

  $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
    type: "line",
    height: "70",
    width: "100%",
    lineWidth: "2",
    lineColor: "#ffa534",
    fillColor: "rgba(255, 165, 52, .14)",
  });
</script>
<script>
    $(document).ready(function () {
      $("#basic-datatables").DataTable({});

      $("#multi-filter-select").DataTable({
        pageLength: 5,
        initComplete: function () {
          this.api()
            .columns()
            .every(function () {
              var column = this;
              var select = $(
                '<select class="form-select"><option value=""></option></select>'
              )
                .appendTo($(column.footer()).empty())
                .on("change", function () {
                  var val = $.fn.dataTable.util.escapeRegex($(this).val());

                  column
                    .search(val ? "^" + val + "$" : "", true, false)
                    .draw();
                });

              column
                .data()
                .unique()
                .sort()
                .each(function (d, j) {
                  select.append(
                    '<option value="' + d + '">' + d + "</option>"
                  );
                });
            });
        },
      });

      // Add Row
      $("#add-row").DataTable({
        pageLength: 5,
      });

      var action =
        '<td> <div class="form-button-action"> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

      $("#addRowButton").click(function () {
        $("#add-row")
          .dataTable()
          .fnAddData([
            $("#addName").val(),
            $("#addPosition").val(),
            $("#addOffice").val(),
            action,
          ]);
        $("#addRowModal").modal("hide");
      });
    });
  </script>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script>
let notificationInterval;

$(document).ready(function () {
    function fetchNotifications() {
        $.ajax({
            url: "{{ route('notifications.fetch') }}", // Backend route
            type: "GET",
            dataType: "json",
            success: function (response) {
                console.log(response); // Debugging: Check if data is received

                if (response.length > 0) {
                    let notifications = response;
                    let notifCount = notifications.length;

                    // ✅ Update Notification Count
                    $("#notif-count").text(notifCount);
                    $("#notif-title").text(notifCount);

                    // ✅ Clear previous notifications
                    $("#notification-list").empty();

                    // ✅ Append new notifications
                    notifications.forEach(function (notif) {
                        $("#notification-list").append(`
                            <a href="#">
                                <div class="notif-icon notif-primary">
                                    <i class="fa fa-bell"></i>
                                </div>
                                <div class="notif-content">
                                    <span class="block">${notif.message}</span>
                                    <span class="time">${notif.title}</span>
                                </div>
                            </a>
                        `);
                    });
                } else {
                    $("#notif-count").text("0");
                    $("#notif-title").text("0");
                    $("#notification-list").html('<p class="text-center p-3">No new notifications</p>');
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching notifications:", error);
            }
        });
    }

    // Fetch notifications on page load
    fetchNotifications();

    // Prevent multiple intervals
    if (notificationInterval) {
        clearInterval(notificationInterval);
    }
    notificationInterval = setInterval(fetchNotifications, 30000); // 30 seconds
});

</script>

</body>
</html>
