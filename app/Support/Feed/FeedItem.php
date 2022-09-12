<?php

namespace App\Support\Feed;

use SimplePie_Item;

class FeedItem extends SimplePie_Item
{
    /**
     * Get the media:content of the item
     *
     * Uses `<media:thumbnail>`
     *
     *
     * @return array|null
     */
    public function get_media()
    {
        if (!isset($this->data['content']))
        {
            if ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_MEDIARSS, 'content'))
            {
                $this->data['content'] = $return[0]['attribs'][''];
            }
            else
            {
                $this->data['content'] = null;
            }
        }
        return $this->data['content'];
    }
}
