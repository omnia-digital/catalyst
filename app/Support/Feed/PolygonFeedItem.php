<?php

namespace App\Support\Feed;

use SimplePie_Item;

class PolygonFeedItem extends FeedItem
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
        $return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'content');

        if (!isset($this->data['content']))
        {
            if ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'content'))
            {
                $this->data['content'] = html_entity_decode($return[0]['data']);
            }
            else
            {
                $this->data['content'] = null;
            }
        }
        return $this->data['content'];
    }
}
