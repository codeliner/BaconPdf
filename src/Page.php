<?php
/**
 * BaconPdf
 *
 * @link      http://github.com/Bacon/BaconPdf For the canonical source repository
 * @copyright 2015 Ben 'DASPRiD' Scholzen
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace Bacon\Pdf;

use Bacon\Pdf\Object\AbstractObject;
use Bacon\Pdf\Object\DictionaryObject;
use Bacon\Pdf\Object\IndirectObject;
use Bacon\Pdf\Object\NameObject;
use Bacon\Pdf\Object\NullObject;
use SplFileObject;

class Page extends AbstractObject
{
    /**
     * @var Document
     */
    private $document;

    /**
     * @var IndirectObject
     */
    private $indirectReference;

    /**
     * @var DictionaryObject
     */
    private $dictionary;

    /**
     * @param Document $document
     * @param int      $width
     * @param int      $height
     */
    public function __construct(Document $document, IndirectObject $indirectReference, $width, $height)
    {
        $this->document = $document;
        $this->indirectReference = $indirectReference;

        $this->dictionary = new DictionaryObject();
        $this->dictionary['Type'] = new NameObject('Page');
        $this->dictionary['Parent'] = new NullObject();
        $this->dictionary['Resources'] = new DictionaryObject();
        $this->dictionary['MediaBox'] = new RectangleObject(0, 0, $width, $height);
    }

    /**
     * @return IndirectObject
     */
    public function getIndirectReference()
    {
        return $this->indirectReference;
    }

    /**
     * {@inheritdoc}
     */
    public function writeToStream(SplFileObject $fileObject, $encryptionKey)
    {
        $this->dictionary->writeToStream($fileObject, $encryptionKey);
    }
}
