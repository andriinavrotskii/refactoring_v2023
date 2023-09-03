<?php

use App\Common\Output\OutputInterface;
use App\Presentation\Controller\TransactionCommissionController;
use App\Presentation\ValueObject\Input;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

require __DIR__ . '/vendor/autoload.php';

$container = new ContainerBuilder();
$loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/config'));
$loader->load('services.yaml');
$container->compile();

/** @var TransactionCommissionController $controller */
$controller = $container->get(TransactionCommissionController::class);
try {
    $controller->run(Input::createFromArgv($argv));
} catch (Exception $exception) {
    /** @var $output OutputInterface $controller */
    $output = $container->get(OutputInterface::class);
    $output->echo($exception->getMessage());
}
