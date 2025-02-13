@extends('layouts.app')
@if(Auth::guard('admin')->check())
@section('title','Admin Panel')

@endif
@section('content-page')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Dashboard</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-md-3">
                  <div class="card card-stats card-round">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col-icon">
                          <div
                            class="icon-big text-center icon-primary bubble-shadow-small"
                          >
                            <i class="fas fa-bus-alt"></i>
                          </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                          <div class="numbers">
                            <p class="card-category">Total Vehicles</p>
                            {{-- <h4 class="card-title"  id="total-vehicles">{{ $vehicle_count }}</h4> --}}
                            <h4 class="card-title"  id="total-vehicles"></h4>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-md-3">
                  <div class="card card-stats card-round">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col-icon">
                          <div
                            class="icon-big text-center icon-info bubble-shadow-small"
                          >
                            <i class="fas fa-gas-pump"></i>
                          </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                          <div class="numbers">
                            <p class="card-category">Total Fuel Filled</p>
                            {{-- <h4 class="card-title"  id="total-fuel">{{ $total_fuel_consumed}} ltr</h4> --}}
                            <h4 class="card-title"  id="total-fuel"> ltr</h4>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-md-3">
                  <div class="card card-stats card-round">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col-icon">
                          <div
                            class="icon-big text-center icon-success bubble-shadow-small"
                          >
                            <i class="fas fa-user-check"></i>
                          </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                          <div class="numbers">
                            <p class="card-category">Total Customers</p>
                            {{-- <h4 class="card-title"  id="total-customers">{{ $customer_count}}</h4> --}}
                            <h4 class="card-title"  id="total-customers"></h4>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-md-3">
                  <div class="card card-stats card-round">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col-icon">
                          <div
                            class="icon-big text-center icon-secondary bubble-shadow-small"
                          >
                            <i class="fas fa-users"></i>
                          </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                          <div class="numbers">
                            <p class="card-category">Total Driver</p>
                            {{-- <h4 class="card-title" id="total-drivers">{{ $driver}}</h4> --}}
                            <h4 class="card-title" id="total-drivers"></h4>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
    function fetchDashboardData() {
        $.ajax({
            url: '/dashboard-data',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#total-vehicles').text(response.total_vehicles);
                $('#total-fuel').text(response.total_fuel + ' ltr');
                $('#total-customers').text(response.total_customers);
                $('#total-drivers').text(response.total_drivers);
            }
        });
    }

    fetchDashboardData(); // Initial call
    setInterval(fetchDashboardData, 5000); // Refresh every 5 seconds
});
</script>
@endsection
