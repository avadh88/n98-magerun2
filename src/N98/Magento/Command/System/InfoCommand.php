<?php

namespace N98\Magento\Command\System;

use N98\Magento\Command\AbstractMagentoCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use N98\Util\Console\Helper\Table\Renderer\RendererFactory;

class InfoCommand extends AbstractMagentoCommand
{
    /**
     * @var array
     */
    protected $infos;

    protected function configure()
    {
        $this
            ->setName('sys:info')
            ->setDescription('Prints infos about the current magento system.')
            ->addOption(
                'format',
                null,
                InputOption::VALUE_OPTIONAL,
                'Output Format. One of [' . implode(',', RendererFactory::getFormats()) . ']'
            )
        ;
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->detectMagento($output, true);

        if ($input->getOption('format') == null) {
            $this->writeSection($output, 'Magento System Information');
        }

        $this->initMagento();

        $table = array(
            array(
                'name'  => 'Version',
                'value' => \Magento\Framework\AppInterface::VERSION,
            )
        );

        $this->getHelper('table')
            ->setHeaders(array('name', 'value'))
            ->renderByFormat($output, $table, $input->getOption('format'));
    }
}