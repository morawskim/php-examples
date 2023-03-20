<?php

require_once __DIR__ . '/vendor/autoload.php';

$parsedTemplatePath = __DIR__ . '/templates/example.html.twig';

if (!file_exists($parsedTemplatePath)) {
    fprintf(STDERR, "Template '%s' not exists. Did you forget to call make compile-mjml-template\n", $parsedTemplatePath);
    exit(1);
}

$templates = [
    'templates/example.html.twig' => file_get_contents($parsedTemplatePath),
];
$loader = new \Twig\Loader\ArrayLoader($templates);

$twig = new \Twig\Environment($loader, [
    'debug' => true,
    'cache' => false,
    'autoescape' => fn($name) => 'html',
]);

$content = $twig->render('templates/example.html.twig', ['text' => 'Vestibulum ac ante dignissim, suscipit mi non, bibendum sapien. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Duis nec mattis dui. Ut aliquet justo et ante tincidunt facilisis. Quisque lacinia pharetra justo. Aliquam nec enim ornare ante commodo pellentesque eu et ipsum. Curabitur laoreet, nibh sit amet elementum mollis, ex neque mollis nibh, ut vehicula augue nibh fermentum massa. In molestie velit a ullamcorper sollicitudin. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam dignissim feugiat gravida. Mauris tincidunt lacus vitae neque sollicitudin viverra. Praesent tortor velit, euismod sed eros quis, tincidunt faucibus purus. Integer ultricies rutrum risus, facilisis lobortis purus tincidunt eget. Mauris congue vulputate velit sit amet efficitur.']);

$email = (new \Symfony\Component\Mime\Email())
    ->from('hello@example.com')
    ->to('someone@example.com')
    ->html($content);

$dsn = \Symfony\Component\Mailer\Transport\Dsn::fromString('smtp://user:pass@mailhog:1025');
$mailer = new \Symfony\Component\Mailer\Mailer(
    (new \Symfony\Component\Mailer\Transport\Smtp\EsmtpTransportFactory())->create($dsn)
);
$mailer->send($email);
