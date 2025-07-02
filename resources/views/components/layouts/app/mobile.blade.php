<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark scroll-smooth md:scroll-auto" >
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-white dark:bg-zinc-800">

    <x-layouts.app.navbar />

      <main>
            {{ $slot }}
      </main>

    <x-layouts.app.footer/>

@include('partials.script')
<script>
  snap.pay(snapToken, {
    onSuccess: function (result) {
      window.location.href = '/booking/success/' + result.order_id;
    },
    onPending: function (result) {
      window.location.href = '/booking/success/' + result.order_id;
    },
    onError: function (result) {
      alert("Pembayaran gagal.");
    }
  });

</script>
</body>
</html>