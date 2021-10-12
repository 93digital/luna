import { __ } from '@wordpress/i18n';
import { Button } from '@wordpress/components';
import './editor.scss';

import {
  sortableContainer,
  sortableElement,
  sortableHandle
} from 'react-sortable-hoc';

import { dragHandle } from '@wordpress/icons';

export const arrayMove = (array, from, to) => {
  array = array.slice();
  array.splice(to < 0 ? array.length + to : to, 0, array.splice(from, 1)[0]);
  return array;
};

// Drag handler
const DragHandle = sortableHandle(() => (
  <span className="drag-handle" aria-label={ __('Drag', 'luna') }>
    <Button
      icon={ dragHandle }
      className="drag-handle__icon"
      disabled
    />
  </span>
));

// Draggable elements.
export const SortableItem = sortableElement(({ children }) => (
  <div className="sort-item">
    { children }
    <DragHandle />
  </div>
));

// Drag area.
export const SortableContainer = sortableContainer(({ children }) => {
  return <div className="sort-container">{ children }</div>;
});