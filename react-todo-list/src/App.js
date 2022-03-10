import React, { useEffect, useReducer } from "react";

import "./App.css";
import { useForm } from "./hooks/useForm";
import { todoReducer } from "./reducers/todoReducer";

//Estado inicial
const init = () => {
    return JSON.parse(localStorage.getItem("todos")) || [];
};

function App() {
    const [todos, dispatch] = useReducer(todoReducer, [], init);
    const [{ description }, handleInputChange, reset] = useForm({
        description: "",
    });

    useEffect(() => {
        localStorage.setItem("todos", JSON.stringify(todos));
    }, [todos]);

    const handleSubmit = (e) => {
        e.preventDefault();

        if (description.trim().length <= 1) {
            return;
        }

        const newTodo = {
            id: new Date().getTime(),
            desc: description,
            done: false,
        };

        const action = {
            type: "add",
            payload: newTodo,
        };

        dispatch(action);
        reset();
    };

    const handleDelete = (todoId) => {
        const action = {
            type: "delete",
            payload: todoId,
        };

        dispatch(action);
    };

    const handleCompleteTodo = (todoId) => {
        const action = {
            type: "toggle",
            payload: todoId,
        };
        dispatch(action);
    };

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
                                <form onSubmit={handleSubmit}>
                                    <div className="add-items d-flex">
                                        <input
                                            type="text"
                                            name="description"
                                            className="form-control todo-list-input"
                                            placeholder="Que vas hacer hoy?"
                                            autoComplete="off"
                                            value={description}
                                            onChange={handleInputChange}
                                        />
                                        <button
                                            type="submit"
                                            className="add btn btn-primary font-weight-bold todo-list-add-btn"
                                        >
                                            Agregar todo
                                        </button>
                                    </div>
                                </form>
                                <div className="list-wrapper">
                                    <ul className="d-flex flex-column-reverse todo-list">
                                        {todos.map((todo) => (
                                            <li key={todo.id}>
                                                <div className="form-check">
                                                    <label
                                                        onClick={() =>
                                                            handleCompleteTodo(
                                                                todo.id
                                                            )
                                                        }
                                                        className={
                                                            todo.done
                                                                ? "complete checkbox form-check-label"
                                                                : "form-check-label"
                                                        }
                                                    >
                                                        <input
                                                            className="checkbox"
                                                            type="checkbox"
                                                            checked={
                                                                todo.done
                                                                    ? true
                                                                    : false
                                                            }
                                                        />
                                                        {todo.desc}
                                                        <i className="input-helper"></i>
                                                    </label>
                                                </div>
                                                <i className="remove mdi mdi-close-circle-outline"></i>
                                            </li>
                                        ))}
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
