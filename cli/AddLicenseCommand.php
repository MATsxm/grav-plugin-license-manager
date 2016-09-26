<?php
namespace Grav\Plugin\Console;

use Github\Api\Enterprise\License;
use Grav\Common\GPM\Licenses;
use Grav\Console\ConsoleCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class AddLicenseCommand
 *
 * @package Grav\Plugin\Console
 */
class AddLicenseCommand extends ConsoleCommand
{
    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName("add")
            ->setDescription("Adds a license")
            ->addOption(
                'slug',
                's',
                InputOption::VALUE_REQUIRED,
                'The product slug (e.g. admin-pro)'
            )
            ->addOption(
                'license',
                'l',
                InputOption::VALUE_REQUIRED,
                'The product license (received when you purchased the product)'
            )
            ->setHelp('The <info>add command</info> adds a license entry for a premium plugin/theme')
        ;
    }

    /**
     * @return int|null|void
     */
    protected function serve()
    {
        $this->output->writeln('');
        $this->output->writeln('<magenta>Displaying License</magenta>');
        $this->output->writeln('');

        $slug = $this->input->getOption('slug', null);

        $licenses = Licenses::get($slug);

        foreach ($licenses as $slug => $license) {
            $this->output->writeln('Successfully added license for: <cyan>' . $slug . '</cyan> = <yellow>'. $license . '</yellow>');
        }
    }

}
