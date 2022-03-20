## CSV

Fetch CSV report without buffering (data will be displayed immediately): 
`curl --no-buffer -v  http://report.lvh.me/csv`

## XLSX

With default configuration for service `App\Report\Provider\RandomDataWithDelayProvider` this report will never be generated.
To stream XLSX data We need first create whole file.
See [ Streaming XLSX download with 100k records for browser requires downloader a long wait before download begins. #582 ](https://github.com/box/spout/issues/582)

The default [Nginx configuration for proxy_read_timeout is 60s](http://nginx.org/en/docs/http/ngx_http_proxy_module.html#proxy_read_timeout),
after this time Nginx will close this connection.

`curl --no-buffer -v --output report.xlsx http://report.lvh.me/xlsx`

## Architecture

The controller `\App\Controller\ExportController` define two endpoints `/csv` and `/xlsx`,
which  use a facade `\App\Report\GenerateReportFacade` to generate report in specific format.
We have one implementation of `\App\Report\ReportDataProviderInterface`, which generates random data using generator
to prevent against huge memory usage.
An interface `\App\Report\ReportDumperInterface` define one public method. 
XLSX dumper use library `box/spout` to build XLSX file.
CSV dumper use standard PHP function `fputcsv`.
We can pass context (to each dumper), which has to implement `\App\Report\ReportGenerateContextInterface`.

## Debugging

### Debugging output streaming from PHP-FPM

1. Run shell in httpd container - `docker-compose exec httpd sh`
2. Install tcpdump - `apk update && apk add tcpdump`  
3. Execute `tcpdump -nn -i any -A -s 0 port 9000`
