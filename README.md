# ResponseAPI Trait Documentation

Trait ini menyediakan struktur yang konsisten untuk respons API di seluruh aplikasi. Trait ini mendukung berbagai status respons seperti `success`, `error`, `error_validation`, `unauthorized`, dan `forbidden`.

## Kenapa Menggunakan Traits?

1. Reusability (Dapat Digunakan Ulang): Traits memungkinkan kode untuk digunakan kembali tanpa perlu mewarisi kelas yang sama. Ini menghindari pengulangan kode di banyak tempat, terutama di kontroler yang mungkin memerlukan format respons API yang konsisten.

2. Decoupling (Pemisahan Logika): Traits membantu memisahkan logika respons API dari kelas utama (misalnya, Controller). Ini membuat kode lebih modular dan lebih mudah dikelola.

3. Consistent Responses: Dengan menggunakan traits, Anda memastikan bahwa semua respons API di seluruh aplikasi Anda memiliki struktur dan format yang konsisten, sehingga meningkatkan maintainability dan pengalaman pengembang yang baik.

## Cara mengunakan trait Response API

1. Tambahkan trait `ResponseAPI` ke dalam controller atau kelas apapun di mana Anda ingin menggunakannya.

```php
use App\Traits\ResponseAPI;

class ExampleController extends Controller
{
    use ResponseAPI;
}
```

## Penggunaan

### 1. Success Response

Gunakan ini saat permintaan berhasil diproses, dan Anda ingin mengembalikan data beserta pesan sukses.

```php
return $this->requestSuccessData($data, 'success', 'Operation completed successfully');
```

- **Parameter:**

  - `$data`: Data yang akan dikembalikan.
  - `$status`: Secara default adalah `'success'`.
  - `$message`: Pesan sukses kustom. Secara default adalah `'Success!'`.

- **Contoh Respons:**

```json
{
  "status": "success",
  "message": "Operation completed successfully",
  "data": {
    /* Your data here */
  }
}
```

### 2. Error Response

Gunakan ini saat terjadi kesalahan, seperti permintaan yang buruk atau masalah lain yang tidak memenuhi syarat validasi.

```php
return $this->badRequest('invalid_request', 'Invalid data provided');
```

- **Parameter:**

  - `$error`: Jenis kesalahan yang spesifik.
  - `$message`: Pesan kesalahan kustom.

- **Contoh Respons:**

```json
{
  "status": "error",
  "message": "Invalid data provided",
  "errors": "invalid_request"
}
```

### 3. Validation Error Response

Gunakan ini saat validasi input gagal, dan Anda ingin mengembalikan pesan kesalahan yang detail untuk setiap field yang tidak valid.

```php
return $this->requestValidation($errors, 'Validation failed');
```

- **Parameter:**

  - `$errors`: Array asosiatif yang berisi pesan kesalahan validasi (misalnya, nama field dan pesan).
  - `$message`: Pesan kesalahan validasi kustom.

- **Contoh Respons:**

```json
{
  "status": "error_validation",
  "message": "Validation failed",
  "errors": {
    "email": "The email field is required."
  }
}
```

### 4. Unauthorized Response

Gunakan ini saat permintaan tidak terotorisasi (misalnya, saat autentikasi diperlukan tetapi tidak ada atau tidak valid).

```php
return $this->requestUnauthorized('Unauthorized access', 'You do not have permission');
```

- **Parameter:**

  - `$message`: Pesan kustom untuk unauthorized.
  - `$errors`: Detil kesalahan kustom. Secara default adalah `'Unauthorized'`.

- **Contoh Respons:**

```json
{
  "status": "unauthorized",
  "message": "Unauthorized access",
  "errors": "You do not have permission"
}
```

### 5. Forbidden Response

Gunakan ini saat permintaan dilarang (misalnya, pengguna tidak memiliki izin yang cukup).

```php
return response()->json([
    "status" => "forbidden",
    "message" => "You do not have permission to perform this action"
], 403);
```

- **Contoh Respons:**

```json
{
  "status": "forbidden",
  "message": "You do not have permission to perform this action"
}
```

## Ringkasan Kode Status

- **Sukses:** `status: success` dengan kode HTTP 200.
- **Error:** `status: error` dengan kode HTTP 400 untuk permintaan yang buruk.
- **Kesalahan Validasi:** `status: error_validation` dengan kode HTTP 422 untuk masalah validasi input.
- **Tidak Terotorisasi:** `status: unauthorized` dengan kode HTTP 401 saat autentikasi hilang atau tidak valid.
- **Terlarang:** `status: forbidden` dengan kode HTTP 403 saat pengguna tidak memiliki izin yang cukup.

## Contoh: Integrasi di Controller

```php
use App\Traits\ResponseAPI;

class UserController extends Controller
{
    use ResponseAPI;

    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return $this->requestNotFound('User not found');
        }

        return $this->requestSuccessData($user, 'success', 'User retrieved successfully');
    }
}
```

Dengan menggunakan trait ini, Anda dapat memastikan bahwa semua respons API di aplikasi Anda memiliki format yang konsisten, sehingga aplikasi lebih mudah dikelola dan memberikan pengalaman pengembangan yang lebih baik.

### Penjelasan:

- **`requestSuccessData`**: Digunakan untuk mengembalikan respons sukses dengan data.
- **`badRequest`**: Mengembalikan respons error jika terjadi kesalahan pada permintaan.
- **`requestValidation`**: Mengembalikan respons jika validasi gagal.
- **`requestUnauthorized`**: Digunakan ketika permintaan tidak terotorisasi.
- **`forbidden`**: Digunakan ketika permintaan tidak diizinkan (forbidden).
