@extends('layouts.back_layouts.back-master')
@section('css_before')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
<div class="container">
    <div class="row">
        <h4>Consumption report</h4>
        <form action="{{ route('report') }}" method="POST">
            @csrf 
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="startDate">Start Date</label>
                        <input type="date" class="form-control" name="startDate" id="startDate" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="endDate">End Date</label>
                        <input type="date" class="form-control" name="endDate" id="endDate" required>
                    </div> 
                </div>
                <div class="col-md-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary mt-2">Submit</button>       
                </div>
            </div>
        </form>
    </div>

    @if(isset($groupedReport))
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Report Results</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Food Name</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($groupedReport as $foodSort => $items)
                                <?php $totalQuantity = 0; ?>
                                @foreach($items as $item)
                                    <?php $totalQuantity += $item['quantity']; ?>
                                @endforeach
                            
                                <!-- Prikaz naziva vrste i ukupne količine -->
                                <tr class="table-info font-weight-bold">
                                    <td colspan="2" class="text-center">
                                        <strong>{{ $foodSort }}</strong> (Total: {{ $totalQuantity }})
                                    </td>
                                </tr>
                            
                                <!-- Prikaz pojedinačnih namirnica u grupi -->
                                @foreach($items as $item)
                                <tr>
                                    <td>{{ $item['food_name'] }}</td>
                                    <td>{{ $item['quantity'] }}</td>
                                </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>
    @endif
</div>
@endsection