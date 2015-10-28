<?php
namespace Starter\AppBundle\Twig;

use JMS\Serializer\SerializerBuilder;

/**
 * Class AppExtension
 * @package Starter\AppBundle\Twig
 */
class AppExtension extends \Twig_Extension
{
    /**
     * @return array
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('toJson', array($this, 'toJson')),
        );
    }

    /**
     * @param $data
     */
    public function toJson($data)
    {
        $serializer = SerializerBuilder::create()->build();
        $jsonContent = $serializer->serialize($data, 'json');
        echo $this->jsonPretty(htmlentities($jsonContent), true);
    }

    /**
     * @param $json
     * @param bool|false $html
     * @return string
     */
    private function jsonPretty($json, $html = false)
    {
        $tabCount = 0;
        $result = '';
        $inQuote = false;
        $ignoreNext = false;
        if ($html) {
            $tab = "&nbsp;&nbsp;";
            $newline = "<br/>";
        } else {
            $tab = "\t";
            $newline = "\n";
        }
        $length = strlen($json);
        for ($i = 0; $i < $length; $i++) {
            $char = $json[$i];
            if ($ignoreNext) {
                $result .= $char;
                $ignoreNext = false;
            } else {
                switch ($char) {
                    case '{':
                        $tabCount++;
                        $result .= $char . $newline . str_repeat($tab, $tabCount);
                        break;
                    case '}':
                        $tabCount--;
                        $result = trim($result) . $newline . str_repeat($tab, $tabCount) . $char;
                        break;
                    case ',':
                        $result .= $char . $newline . str_repeat($tab, $tabCount);
                        break;
                    case '"':
                        $inQuote = !$inQuote;
                        $result .= $char;
                        break;
                    case '\\':
                        if ($inQuote) {
                            $ignoreNext = true;
                        }
                        $result .= $char;
                        break;
                    default:
                        $result .= $char;
                }
            }
        }
        return $result;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'app_extension';
    }
}
