import DataTable from 'react-data-table-component';
import {useMemo} from "react";
import {Button, DropdownButton,Dropdown} from "react-bootstrap";
import {ButtonGroup} from "reactstrap";
import {BsEye, BsPencil, BsTrash} from "react-icons/bs";
const UserList = ({data,handleViewButton,handleEditButton,handleDeleteButton}) => {

    const columns = useMemo(
        () => [
            {
                name: 'UserType',
                selector: row => row.user_type,
                sortable: true,
                grow: 2,
            },
            {
                name: 'Name',
                selector: row => row.name,
                sortable: false,
            },
            {
                name: 'Email',
                selector: row => row.email,
                sortable: false,
            },
            {
                name: 'Phone Number',
                selector: row => row.phone_number,
                sortable: false
            },
            {
                cell: () => <>
                    <ButtonGroup size="sm">
                        <Button className="btn-fill" variant="success" onClick={handleViewButton}><BsEye/></Button>
                        <Button className="btn-fill" variant="info" onClick={handleEditButton}><BsPencil/></Button>
                        <Button className="btn-fill" variant="danger" onClick={handleDeleteButton}><BsTrash/></Button>
                    </ButtonGroup>
                </>,
                ignoreRowClick: true,
                allowOverflow: true,
                button: true,
            },
        ],
        [],
    );

return (
    <DataTable
        title=""
        data={data}
        columns={columns}
        pagination
    />
);
}

export default UserList;