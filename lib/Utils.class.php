<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 fdm=marker: */

/**
 * 色々使いそうな汎用関数
 *
 * @package
 * @author    $Author$
 * @date      $Date$
 * @version   $Id$
 * @copyright peka-lab
 */

require_once "XML/Serializer.php";
require_once "XML/Unserializer.php";

class Utils {

    // {{{ public static function arrayToXml($data)
    /**
     *
     * @param
     * @return 
     */
    public static function arrayToXml($data)
    {
        $options = array(
                XML_SERIALIZER_OPTION_INDENT => "\t",
                XML_SERIALIZER_OPTION_XML_ENCODING => 'UTF-8',
                XML_SERIALIZER_OPTION_XML_DECL_ENABLED => TRUE,
                XML_SERIALIZER_OPTION_ROOT_NAME => 'Object',
                XML_SERIALIZER_OPTION_DEFAULT_TAG => 'item',
                );
        if(!is_array($data)){
            $data = (array)$data;
        }

        $serializer = new XML_Serializer($options);
        $serializer->serialize($data);

        $result = $serializer->getSerializedData();

        return $result;

    }
    // }}}

    // {{{ public static function xmlToArray($xml)
    /**
     *
     * @param
     * @return 
     */
    public static function xmlToArray($xml)
    {
        $options = array(
            'parseAttributes' => true
            );

        $serializer = new XML_Unserializer($options);
        $serializer->unserialize($xml);
        $result = $serializer->getUnserializedData();

        return $result;

    }
    // }}}


}

