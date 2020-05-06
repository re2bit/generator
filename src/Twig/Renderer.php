<?php

namespace Re2bit\Generator\Twig;

use Symfony\Component\Console\Output\OutputInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

/**
 * @author  Rene Gerritsen <rene.gerritsen@me.com>
 */
class Renderer
{
    /** @var Environment */
    private $twig;

    /** @var string */
    private $outputDirectory;
    /**
     * @var OutputInterface
     */
    private $output;

    public function __construct(
        string $outputDirectory,
        string $templateDirectory = __DIR__ . '/views',
        Environment $twig = null,
        OutputInterface $output = null
    ) {
        if (!$twig) {
            $loader = new FilesystemLoader([$templateDirectory]);
            $twig = new Environment($loader, [
                'autoescape' => false
            ]);
        }
        $this->twig = $twig;
        $this->twig->addExtension(new InflectorExtension());
        $this->outputDirectory = $outputDirectory;
        $this->output = $output;
    }

    /**
     * @param string $template
     * @param array  $variables
     *
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render(string $template, array $variables = []) : string
    {
        $twigTpl = $this->twig->load($template);
        $data = $this->twig->render($twigTpl, $variables);
        return $data;
    }

    public function renderToFilesystem(array $fileSystem, $baseDir = null)
    {
        $baseDir = $baseDir ?? $this->outputDirectory;
        foreach ($fileSystem as $key => $value) {
            if (isset($value['template'])) {
                if ($this->output) {
                    $this->output->writeln('r: ' . $value['template']);
                }
                $data = $this->render($value['template'], $value['variables']);
                file_put_contents(
                    $baseDir . DIRECTORY_SEPARATOR . $key,
                    $data
                );
                if ($this->output) {
                    $lines = substr_count($data, PHP_EOL);
                    $this->output->writeln('w: ' . $key . ' - written ' . $lines . ' Lines');
                }
                continue;
            }
            $dir = $baseDir . DIRECTORY_SEPARATOR . $key ;
            if (!is_dir($dir) && !mkdir($dir) && !is_dir($dir))
            {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $dir));
            }
            $this->renderToFilesystem($value, $baseDir . DIRECTORY_SEPARATOR . $key);
        }
    }
}
