import React, {useState} from "react";
import {
    Badge,
    Button,
    Card,
    Navbar,
    Nav,
    Table,
    Container,
    Row,
    Col, Modal,
} from "react-bootstrap";
import UserList from "../../components/User/UserList";
import UserViewModel from "../../components/User/View";
import UserAdd from "../../components/User/Add";
import UserEdit from "../../components/User/Edit";

function User() {
    const [showAddModal, setShowAddModal] = useState(false);
    const [showEditModal, setShowEditModal] = useState(false);
    const [showViewModal, setShowViewModal] = useState(false);
    const [modalTitle, setModalTitle] = useState("Add User");
    const [editableData, setEditableData] = useState({});
    const [viewableData, setViewableData] = useState({});

    const handleAddModalClose = () => setShowAddModal(false);
    const handleEditModalClose = () => setShowEditModal(false);
    const handleViewModalClose = () => setShowViewModal(false);

    const handleCreateUserAction = (data) => {
        console.log("add-data", {data});
    }

    const handleUpdateUserAction = (data) => {
        console.log("update-data", {data});
    }
    const userList = [];

    const handleEditButton = (event) => {
        setModalTitle("Edit User")
        setShowEditModal(true);
        setEditableData({
            id: 1,
            user_type: "Admin",
            name: "Arif",
            email: "arif@gmail.com",
            phone_number: "0176767111"
        })
    }
    const handleViewButton = (event) => {
        setShowViewModal(true);
        setViewableData({
            user_type: "Admin",
            name: "Arif",
            email: "arif@gmail.com",
            phone_number: "0176767111"
        })
    }
    const handleDeleteButton = (event) => {
        console.log(event);
    }
    const addModalOpenHandler = () => {
        setModalTitle("Add User")
        setShowAddModal(true)
        setEditableData({});
    }

    const onSubmitHandler = (data) => {
        return data?.id ? handleUpdateUserAction(data) : handleCreateUserAction(data);
    }

    return (
        <>
            <Container fluid>
                <Row>
                    <Col md="12">
                        <Card className="strpied-tabled-with-hover">
                            <Row>
                                <Col>
                                    <Card.Header>
                                        <h3 className="m-1"><i className="nc-icon nc-circle-09"></i> User List</h3>
                                    </Card.Header>
                                </Col>
                                <Col>
                                    <Button
                                        size="sm"
                                        className="btn-fill btn-sm m-2 float-right"
                                        variant="info"
                                        onClick={addModalOpenHandler}
                                    > <i className="nc-icon nc-simple-add"></i> Add</Button>
                                </Col>
                            </Row>
                        </Card>
                    </Col>
                    <Col md="12">
                        <UserList data={userList} handleViewButton={handleViewButton}
                                  handleEditButton={handleEditButton}
                                  handleDeleteButton={handleDeleteButton}/>
                    </Col>
                </Row>
                <UserAdd show={showAddModal} modalTitle={modalTitle} handleClose={handleAddModalClose}
                                 onSubmitHandler={onSubmitHandler}/>
                <UserEdit show={showEditModal} modalTitle={modalTitle} handleClose={handleEditModalClose}
                         onSubmitHandler={onSubmitHandler} editableData={editableData}/>

                <UserViewModel show={showViewModal} handleClose={handleViewModalClose} data={viewableData}/>
            </Container>
        </>
    );
}

export default User;

