
import { getHttp, postHttp, putHttp, deleteHttp } from '../../../utils/http'

import { tasksChangeStatus, tasksDelete, tasksUpdate, tasksIndex, tasksStore,  } from '../api/endpoints'


const useTodo = () => {

    /**
     * @description Consumes the task index api
     * @return { Object } response
     */
    const _getTasks = async () =>{
        const response = await getHttp(tasksIndex)
        return response
    }
    /**
     * @description Consumes the task store api
     * @param { Object } request
     * @return { Object } response
     */
    const _addTask = async (request) =>{
        const response = await postHttp(tasksStore, request)
        return response
    }
    /**
     * @description Updates the status of the task according to the submitted id
     * @param { Integer } id task id
     * @return { Object } response
     */
    const _changeStatusTask = async (id) =>{
        const response = await putHttp(`${tasksChangeStatus}${id}`)
        return response
    }

    /**
     * @description Deletes the selected task according to the task id
     * @param { Integer } id task id
     * @return { Object } response
     */
    const _deleteTask = async (id) =>{
        const response = await deleteHttp(`${tasksDelete}${id}`)
        return response
    }

    /**
     * @description Consumes the task update api
     */
     const _updateTask = async (id) => {
        const response = await putHttp(tasksUpdate, id)
        return response
    }

    return {
        _addTask,
        _changeStatusTask,
        _deleteTask,
        _getTasks,
        _updateTask,
    }

}

export default useTodo