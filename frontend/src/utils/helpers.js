// src/utils/helpers.js

export function applyDrag(arr, dragResult) {
  const { removedIndex, addedIndex, payload } = dragResult
  if (removedIndex === null && addedIndex === null) return arr

  const result = [...arr]
  let itemToAdd = payload

  if (removedIndex !== null) {
    itemToAdd = result.splice(removedIndex, 1)[0]
  }

  if (addedIndex !== null) {
    result.splice(addedIndex, 0, itemToAdd)
  }

  return result
}

export const scene = {
  children: [
    {
      id: 'column1',
      name: 'Column 1',
      props: { className: 'column-class' },
      children: [
        { id: 'card1', number: 1, data: 'Task 1', props: { className: 'card-class', style: {} } },
        { id: 'card2', number: 2, data: 'Task 2', props: { className: 'card-class', style: {} } }
      ]
    },
    {
      id: 'column2',
      name: 'Column 2',
      props: { className: 'column-class' },
      children: [
        { id: 'card3', number: 3, data: 'Task 3', props: { className: 'card-class', style: {} } }
      ]
    },
    {
      id: 'column3',
      name: 'column 3',
      props: { className: 'column-class' },
      children: [
        { id: 'card3', number: 3, data: 'Task 3', props: { className: 'card-class', style: {} } }
      ]
    },
    {
      id: 'column4',
      name: 'Column 4',
      props: { className: 'column-class' },
      children: [
        { id: 'card3', number: 3, data: 'Task 3', props: { className: 'card-class', style: {} } }
      ]
    }
  ]
}
