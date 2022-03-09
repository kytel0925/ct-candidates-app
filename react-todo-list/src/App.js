import React, { useEffect, useReducer } from "react";

import "./App.css";
import { useForm } from "./hooks/useForm";
import { todoReducer } from "./todoReducer";

//Estado inicial
const init = () => {
    return JSON.parse(localStorage.getItem("todos")) || [];
};

function App() {
    return (
        <div className="page-content page-container" id="page-content">
            <div className="padding">
                <div className="row container d-flex justify-content-center">
                    <div className="col-md-12">
                        <div className="card px-3">
                            <div className="card-body">
                                <h4 className="card-title">
                                    Funiber Todo List
                                </h4>
                                <div className="add-items d-flex">
                                    {" "}
                                    <input
                                        type="text"
                                        className="form-control todo-list-input"
                                        placeholder="Que vas hacer hoy?"
                                    />{" "}
                                    <button className="add btn btn-primary font-weight-bold todo-list-add-btn">
                                        Add
                                    </button>{" "}
                                </div>
                                <div className="list-wrapper">
                                    <ul className="d-flex flex-column-reverse todo-list">
                                        <li>
                                            <div className="form-check">
                                                {" "}
                                                <label className="form-check-label">
                                                    {" "}
                                                    <input
                                                        className="checkbox"
                                                        type="checkbox"
                                                    />{" "}
                                                    For what reason would it be
                                                    advisable.{" "}
                                                    <i className="input-helper"></i>
                                                </label>{" "}
                                            </div>{" "}
                                            <i className="remove mdi mdi-close-circle-outline"></i>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default App;
