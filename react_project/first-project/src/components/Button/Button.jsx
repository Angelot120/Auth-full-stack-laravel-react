
import React, { useState } from "react";
import './Button.css'

export default function Button({text, onClick, type}){
// onContextMenu={e.preventDefault()}
  return(
    <div>
        <button type={type} className="button" onClick={onClick} >{text || "Opérations" }</button>
    </div>
  )
}

