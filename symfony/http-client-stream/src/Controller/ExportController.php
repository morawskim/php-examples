<?php

namespace App\Controller;

use App\Report\Context\NullContext;
use App\Report\Context\StreamContext;
use App\Report\GenerateReportFacade;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;

class ExportController
{
    #[Route(path: "/xlsx", name: "export.xlsx")]
    public function xlsx(GenerateReportFacade $generateReportFacade): Response
    {
        set_time_limit(0);
        $response = new StreamedResponse(function () use ($generateReportFacade) {
            $generateReportFacade->generateXslxReportToStdout(new NullContext());
        });
        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $dispositionHeader = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, 'report.xslx');
        $response->headers->set('Content-Disposition', $dispositionHeader);
        $response->headers->set('X-Accel-Buffering', 'no');
        $response->headers->set('Cache-Control', 'no-cache, must-revalidate');
        $response->setStatusCode(Response::HTTP_OK);

        return $response;
    }

    #[Route(path: "/csv", name: "export.csv")]
    public function csv(GenerateReportFacade $generateReportFacade): Response
    {
        set_time_limit(0);
        $response = new StreamedResponse(function () use ($generateReportFacade) {
            $handler = fopen('php://output', 'wb');
            $generateReportFacade->generateCsvReportToStream(new StreamContext($handler));
        });
        $response->headers->set('Content-Type', 'text/csv');
        $dispositionHeader = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, 'report.csv');
        $response->headers->set('Content-Disposition', $dispositionHeader);
        $response->headers->set('X-Accel-Buffering', 'no');
        $response->headers->set('Cache-Control', 'no-cache, must-revalidate');
        $response->setStatusCode(Response::HTTP_OK);

        return $response;
    }
}
