import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

import Edit from './edit';
import Save from './save';

registerBlockType('luna/m01-hero', {
  apiVersion: 2,
  title: __('M01 Hero', 'luna'),
  description: __('M01 Hero block.', 'luna'),
  category: 'luna-blocks',
  icon: 'align-right',
  supports: {
    html: false
  },
  attributes: {
    heading: {
      type: 'string',
      source: 'html',
      selector: '.m01__heading'
    }
  },
  edit: Edit,
  save: Save
});
