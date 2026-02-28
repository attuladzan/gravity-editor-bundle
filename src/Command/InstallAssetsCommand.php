<?php

declare(strict_types=1);

namespace Attuladzan\MarkdownEditorBundle\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Process\Process;

/**
 * Installs Gravity UI Markdown Editor assets.
 *
 * Runs assets:install and optionally npm build.
 */
#[AsCommand(
    name: 'attuladzan:markdown-editor:install-assets',
    description: 'Installs Gravity UI Markdown Editor assets (JS, CSS) into public directory',
)]
final class InstallAssetsCommand extends Command
{
    public function __construct(
        private readonly KernelInterface $kernel,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('build', null, InputOption::VALUE_NONE, 'Run npm build before installing assets')
            ->addOption('symlink', null, InputOption::VALUE_NONE, 'Symlink assets instead of copying')
            ->setHelp(<<<'HELP'
The command copies pre-built assets from the bundle to <info>public/bundles/</info>.

If you modified the bundle's assets, use <info>--build</info> to rebuild first:

  php bin/console attuladzan:markdown-editor:install-assets --build

Use <info>--symlink</info> to create symlinks instead of copying (useful in development):

  php bin/console attuladzan:markdown-editor:install-assets --symlink
HELP);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if ($input->getOption('build')) {
            $io->section('Building assets');
            $bundlePath = \dirname($this->kernel->locateResource('@AttuladzanMarkdownEditorBundle'));

            $npmRun = Process::fromShellCommandline('npm run build', $bundlePath);
            $npmRun->setTimeout(120);
            $npmRun->run(static fn (string $type, string $buffer) => $output->write($buffer));

            if (!$npmRun->isSuccessful()) {
                $io->error('npm run build failed. Run "npm install" in the bundle directory first.');

                return Command::FAILURE;
            }
            $io->success('Assets built successfully.');
        }

        $io->section('Installing assets');
        $assetsInput = new ArrayInput([
            'command' => 'assets:install',
            'target' => $this->kernel->getProjectDir() . '/public',
            '--symlink' => $input->getOption('symlink'),
        ]);
        $assetsInput->setInteractive(false);

        $code = $this->getApplication()->doRun($assetsInput, $output);

        if (Command::SUCCESS === $code) {
            $io->success('Gravity UI Markdown Editor assets installed.');
        }

        return $code;
    }
}
