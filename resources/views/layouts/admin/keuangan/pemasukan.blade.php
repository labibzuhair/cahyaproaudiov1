@extends('layouts.admin.master.master')

@section('title', 'Riwayat Pemasukan')

@section('content')
<section class="intro">
  <div class="bg-image h-100" style="background-color: #f5f7fa;">
    <div class="mask d-flex align-items-center h-100">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12">
            <div class="card">
              <div class="card-body p-0">
                <div class="table-responsive table-scroll" data-mdb-perfect-scrollbar="true" style="position: relative; height: 600px">
                  <table class="table table-striped mb-0">
                    <thead style="background-color: #002d72; color: white;">
                      <tr>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Keterangan</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($incomes as $income)
                      <tr>
                        <td>{{ $income->date }}</td>
                        <td>Rp {{ number_format($income->amount, 0, ',', '.') }}</td>
                        <td>{{ $income->description }}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
