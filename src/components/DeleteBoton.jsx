import React from 'react';
import '../assets/styles/components/DeleteBoton.scss';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faTrash } from '@fortawesome/free-solid-svg-icons';


const DeleteBoton = (props) => {
  

  
  return (
    <>
      <botton className='tdActions--botton'>
        <FontAwesomeIcon icon={faTrash} />
      </botton>
    </>
  );
};

export default DeleteBoton;