import React, {useState} from 'react';
import Button from 'react-bootstrap/Button';
import Modal from 'react-bootstrap/Modal';
import Form from 'react-bootstrap/Form';
import {Card, Col, Container, Row} from "react-bootstrap";

const UserViewModel = ({show, data, handleClose}) => {
    return (
        <Modal
            show={show}
            onHide={handleClose}
            size="xl"
        >
            <Modal.Header>
                <h4 className="m-1">User Details</h4>
                <Button variant="light" className="float-right btn-fill" size="xs" onClick={handleClose}>
                    <i className="nc-icon nc-simple-remove" color="white"></i>
                </Button>
            </Modal.Header>
            <Modal.Body>
                <Row>
                    <Col md="12">
                        <Card>
                            <Card.Body>
                                <Form>
                                    <Row>
                                        <Col className="pr-1" md="6">
                                            <Form.Group>
                                                <label>UserType</label>
                                                <Form.Control
                                                    defaultValue={data?.name}
                                                    placeholder="Full Name"
                                                    type="text"
                                                    readOnly
                                                ></Form.Control>
                                            </Form.Group>
                                        </Col>
                                        <Col className="pr-1" md="6">
                                            <Form.Group>
                                                <label>Name</label>
                                                <Form.Control
                                                    defaultValue={data?.name}
                                                    placeholder="Full Name"
                                                    type="text"
                                                    readOnly
                                                ></Form.Control>
                                            </Form.Group>
                                        </Col>
                                    </Row>
                                    <Row>
                                        <Col className="pr-1" md="6">
                                            <Form.Group>
                                                <label>Email</label>
                                                <Form.Control
                                                    defaultValue={data?.email}
                                                    placeholder="Email"
                                                    type="text"
                                                    readOnly
                                                ></Form.Control>
                                            </Form.Group>
                                        </Col>
                                        <Col className="pl-1" md="6">
                                            <Form.Group>
                                                <label>Phone Number</label>
                                                <Form.Control
                                                    defaultValue={data?.phone_number}
                                                    placeholder="Phone Number"
                                                    type="text"
                                                    readOnly
                                                ></Form.Control>
                                            </Form.Group>
                                        </Col>
                                    </Row>
                                </Form>
                            </Card.Body>
                        </Card>
                    </Col>
                </Row>
            </Modal.Body>
        </Modal>
    );
}
export default UserViewModel;
