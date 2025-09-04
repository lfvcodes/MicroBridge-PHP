# MicroBridge-PHP API Documentation

## Class: MicroBridge

The main class for handling internal API requests.

### Constructor

```php
public function __construct(string $verb = 'POST')
```

**Parameters:**
- `$verb` (string): HTTP method (GET, POST, PUT, PATCH, DELETE). Default: 'POST'

**Throws:**
- `InvalidArgumentException`: If unsupported HTTP method is provided

**Example:**
```php
$bridge = new MicroBridge('GET');
```

### Methods

#### request()

```php
public function request(string $url, array $payload = [], array $headers = []): array
```

Execute an internal API request.

**Parameters:**
- `$url` (string): Target URL or file path
- `$payload` (array): Request data. Default: empty array
- `$headers` (array): Additional headers. Default: empty array

**Returns:**
- `array`: Response data or error information

**Throws:**
- `InvalidArgumentException`: If payload is not an array

**Example:**
```php
$response = $bridge->request('./api/users.php', ['id' => 1], ['Authorization' => 'Bearer token']);
```

## Class: RequestContext

Manages PHP superglobal state preservation and restoration.

### Methods

#### save()

```php
public function save(): void
```

Save current state of all PHP superglobals.

#### restore()

```php
public function restore(): void
```

Restore previously saved state of all PHP superglobals.

## Class: MockPhpStream

Mock implementation of PHP's input stream.

### Stream Methods

#### stream_open()

```php
public function stream_open($path, $mode, $options, &$opened_path): bool
```

Open the stream.

#### stream_read()

```php
public function stream_read($count): string
```

Read data from the stream.

#### stream_eof()

```php
public function stream_eof(): bool
```

Check if end of stream is reached.

#### stream_stat()

```php
public function stream_stat(): array
```

Get stream statistics.

#### stream_tell()

```php
public function stream_tell(): int
```

Get current position in stream.

#### stream_seek()

```php
public function stream_seek($offset, $whence = SEEK_SET): bool
```

Seek to position in stream.

## Error Handling

All methods return arrays with error information when something goes wrong:

```php
[
    'error' => true,
    'message' => 'Error description',
    'raw_response' => 'Original response if applicable'
]
```

## Supported HTTP Methods

- `GET`: Retrieve data
- `POST`: Create new resource
- `PUT`: Update entire resource
- `PATCH`: Partial update
- `DELETE`: Remove resource