module.exports = {
  '.react-tabs [role=tablist]': {
    'border-bottom': '1px solid #aaa',
    margin: '0 0 10px',
    padding: '0',
  },

  '.react-tabs [role=tab]': {
    display: 'inline-block',
    border: '1px solid transparent',
    'border-bottom': 'none',
    bottom: '-1px',
    position: 'relative',
    'list-style': 'none',
    padding: '6px 12px',
    cursor: 'pointer',
  },

  '.react-tabs [role=tab][aria-selected=true]': {
    background: '#fff',
    'border-color': '#aaa',
    color: 'black',
    'border-radius': '5px 5px 0 0',
    '-moz-border-radius': '5px 5px 0 0',
    '-webkit-border-radius': '5px 5px 0 0',
  },

  '.react-tabs [role=tab][aria-disabled=true]': {
    color: 'GrayText',
    cursor: 'default',
  },

  '.react-tabs [role=tab]:focus': {
    'box-shadow': '0 0 5px hsl(208, 99%, 50%)',
    'border-color': 'hsl(208, 99%, 50%)',
    outline: 'none',
  },

  '.react-tabs [role=tab]:focus:after': {
    content: '""',
    position: 'absolute',
    height: '5px',
    left: '-4px',
    right: '-4px',
    bottom: '-5px',
    background: '#fff',
  },
};
